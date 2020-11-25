<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GlobalController;
use App\Models\CariEkstre;
use App\Models\Teklif;
use App\Models\TeklifGuzergah;
use Illuminate\Http\Request;

class TeklifController extends GlobalController
{
    public function add(Request $req)
    {
        $data = $req->validate([
            "cari_id" => "required|gt:0",
            "teklif_veren" => "required|gt:0",
            "teklif_tutari" => "required",
            "teklif_tarihi" => "required",
            "teklif_baslangic_tarihi" => "required",
            "teklif_bitis_tarihi" => "required",
            "aciklama" => "nullable",
            "guzergahlar" => "nullable",
            "para_birimi" => "nullable",
        ]);
        $res = Teklif::create([
            "cari_id" => $data["cari_id"],
            "teklif_veren" => $data["teklif_veren"],
            "teklif_tutari" => $data["teklif_tutari"],
            "teklif_tarihi" => $data["teklif_tarihi"],
            "teklif_baslangic_tarihi" => $data["teklif_baslangic_tarihi"],
            "teklif_bitis_tarihi" => $data["teklif_bitis_tarihi"],
            "aciklama" => $data["aciklama"],
            "para_birimi" => $data["para_birimi"],
        ]);
        foreach ($data["guzergahlar"] as  $guzergah) {
            TeklifGuzergah::create([
                "ad" => $guzergah["ad"],
                "personel_sayisi" => $guzergah["personel_sayisi"],
                "kilometre" => $guzergah["kilometre"],
                "arac_sayisi" => $guzergah["arac_sayisi"],
                "teklif_id" => $res->id,
            ]);
        }
        return $this->resSuccess($res, "Teklif Eklemesi Başarılı");
    }

    public function get()
    {
        $goTo = [];
        foreach (Teklif::where("gosterim", 1)->with(["personel", "cari", "paraBirimi"])->get() as $teklif) {
            $goTo[] = [
                "id" => $teklif->id,
                "cari" => $teklif->cari->ad,
                "teklif_veren" => $teklif->personel->ad,
                "tutar" => $teklif->teklif_tutari . $teklif->paraBirimi->kod,
                "teklif_tarihi" => $teklif->teklif_tarihi,
                "teklif_durumu" => $teklif->durum == 1 ? "Bekliyor" : ($teklif->durum == 2 ? "Reddedilmiş" : "Kabul Edilmiş"),
            ];
        }
        return $this->resSuccess($goTo);
    }
    public function delete()
    {
        return true;
    }
    public function getSelect()
    {
        return true;
    }
    public function detail($id)
    {
        $teklif = Teklif::where("id", $id)->with(["guzergahlar", "personel", "cari", "paraBirimi"])->first();
        $teklif->personeller = Teklif::where("id", $id)->with(["guzergahlar", "personel", "cari", "paraBirimi"])->first()->personeller();
        return $this->resSuccess($teklif);
    }
    public function durumGuncelle(Request $req)
    {
        $id = $req->id;

        if ($req->durum == 2) {
            return $this->resSuccess(Teklif::where("id", $id)->update([
                "durum" => $req->durum,
                "iptal_aciklama" => $req->aciklama
            ]));
        } else {
            $teklif = Teklif::where("id", $id)->first();
            CariEkstre::create([
                "islem_turu" => 0,
                "hesap_id" => 0,
                "cari_id" => $teklif->cari_id,
                "islem_id" => $teklif->id,
                "para_birimi" => $teklif->para_birimi,
                "islem_tutar" => $teklif->teklif_tutari,
                "personel_id" => $teklif->teklif_veren,
                "islem_tarih" => date("Y-m-d H:i:s", strtotime($req->kabul_tarihi . " " . date("H:i:s"))) ?? date("Y-m-d H:i:s"),
                "hareket_turu" => 1,
            ]);
            return $this->resSuccess(Teklif::where("id", $id)->update([
                "durum" => $req->durum,
                "kabul_tarihi" => $req->kabul_tarihi
            ]));
        }
    }
}
