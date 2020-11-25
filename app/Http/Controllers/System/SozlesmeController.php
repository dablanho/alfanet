<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GlobalController;
use App\Models\FiyatlandirmaTuru;
use App\Models\Makbuz;
use App\Models\Odeme;
use App\Models\Ogrenciler;
use App\Models\Sozlesme;
use App\Models\VergiGrup;
use Illuminate\Http\Request;

class SozlesmeController extends GlobalController
{
    public function add(Request $req)
    {
        $tarih1 = date("Y-m-d", strtotime($req->baslangic_tarihi));
        $tarih2 = date("Y-m-d", strtotime($req->bitis_tarihi));

        $diff = abs(strtotime($tarih2) - strtotime($tarih1));

        $yil = floor($diff / (365 * 60 * 60 * 24));
        $ay = floor(($diff - $yil * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        $donemler = [];
        $toplamAy = $yil * 12 + $ay;

        $data = $req->validate([
            "ogr_id" => "required",
            "kdv_haric" => "required",
            "baslangic_tarihi" => "required",
            "bitis_tarihi" => "required",
            "para_birimi" => "required",
            "fiyatlandirma_turu" => "nullable",
            "vergi_grubu" => "nullable",
            "sozlesme_baslik" => "nullable",
            "aciklama" => "nullable",
        ]);
        if (empty($data["fiyatlandirma_turu"]))
            $data["fiyatlandirma_turu"] = 0;
        if ($data["vergi_grubu"] > 0)
            $data["tutar"] = $data["kdv_haric"] + ($data["kdv_haric"] * VergiGrup::where("id", $data["vergi_grubu"])->first()->oran / 100);
        else
            $data["tutar"] = $data["kdv_haric"];
        if ($data["fiyatlandirma_turu"] > 0)
            $data["tutar"] = $data["tutar"] - ($data["tutar"] * FiyatlandirmaTuru::where("id", $data["fiyatlandirma_turu"])->first()->oran / 100);
        $sozlesmeID = Sozlesme::insertGetId($data);
        for ($i = 0; $i <= $toplamAy; $i++) {
            /*if(strtotime(date("m", strtotime($tarih1 . "+ " . $i . " month")) < strtotime())*/
            $tutar =
                (date("m", strtotime($tarih1 . "+ " . $i . " month")) == "02" && $req->subat)
                ? $data["tutar"] / 2
                : $data["tutar"];
            Odeme::insert([
                "ogr_id" => $data["ogr_id"],
                "tutar" => $tutar,
                "kalan" => $tutar,
                "sozlesme_id" => $sozlesmeID,
                "para_birimi" => $data["para_birimi"],
                "odeme_tarihi" => date("Y-m-d", strtotime($tarih1 . "+ " . $i . " month")),
                "okul_id" => Ogrenciler::where("id", $data["ogr_id"])->first()->okul,
                "servis_id" => Ogrenciler::where("id", $data["ogr_id"])->first()->servis_id,
                "created_at" => date("Y-m-d H:i:s"),
            ]);
        }


        return $this->resSuccess($sozlesmeID, "Sozlesme Eklemesi Başarılı");
    }
    public function detail($id)
    {
        return $this->resSuccess(Sozlesme::where("id", $id)->first()->getBilgiler());
    }
    public function delete($id)
    {
        return $this->resSuccess(Sozlesme::where("id", $id)->update(["durum" => 0]), "Sozlesme Başarıyla Silindi!");
    }
    public function get($id = 0)
    {
        $goTo = [];
        $sozlesme = new Sozlesme();
        $sozlesme = $id > 0 ? $sozlesme->where("ogr_id", $id) : $sozlesme;
        foreach ($sozlesme->where("durum", 1)->get() as $data) {
            $goTo[] = $data->getListBilgiler();
        }
        return $this->resSuccess($goTo);
    }
    public function getSelect()
    {
        $goTo = [];
        foreach (Sozlesme::where("durum", 1)->get() as $data) {
            $goTo[] = $data->getSelect();
        }
        return $this->resSuccess($goTo);
    }
    public function getUpdate($id)
    {
        $ogr = Sozlesme::where(["durum" => 1, "id" => $id])->first();
        $ogr['okul'] = $ogr->getOkul();
        return $this->resSuccess($ogr);
    }

    public function odemeAl(Request $req)
    {
        $req->validate([
            "tutar" => "numeric|required|gt:0",
            "hesap" => "numeric|required|gt:0",
            "odeme_tarihi" => "required",
            "alan_personel" => "numeric|required|gt:0",
            "ogr_id" => "required",
            "sozlesme_id" => "required",
        ]);
        $data = $req->all();
        $sozlesme = Sozlesme::where("id", $req->sozlesme_id)->first();
        $data["ogr_id"] = $sozlesme->ogr_id;
        $data["para_birimi"] = $sozlesme->para_birimi;
        $tutar = $req->tutar;
        Makbuz::create($data);
        foreach (Odeme::where(["sozlesme_id" => $req->sozlesme_id, "ogr_id" => $data["ogr_id"]])->orderBy("odeme_tarihi", "asc")->get() as $odeme) {
            if ($odeme->kalan > 0) {
                if (($odeme->kalan - $tutar) >= 0) {
                    $kalan = $odeme->kalan - $tutar;
                    $odenen = $odeme->odenen + $tutar;
                    Odeme::where("id", $odeme->id)->update(["kalan" => $kalan, "odenen" => $odenen]);
                    $tutar = 0;
                } else {
                    $kalan = 0;
                    $odenen = $odeme->tutar;
                    Odeme::where("id", $odeme->id)->update(["kalan" => $kalan, "odenen" => $odenen]);
                    $tutar -= $odeme->tutar;
                }
            }
        }
        $this->hesapIslemiYap($req->hesap, $req->tutar, $data["para_birimi"], 4, $data["ogr_id"]);
        return $this->resSuccess(Odeme::where(["sozlesme_id" => $req->sozlesme_id, "ogr_id" => $data["ogr_id"]])->orderBy("odeme_tarihi", "asc")->get());
    }
}
