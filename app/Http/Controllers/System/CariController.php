<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GlobalController;
use App\Models\Cari;
use App\Models\CariCekSenet;
use App\Models\CariEkstre;
use App\Models\HesapHareket;
use App\Models\ParaBirim;
use Illuminate\Http\Request;

class CariController extends GlobalController
{
    public function add(Request $req)
    {
        $data = $req->validate([
            "ad" => "required",
            "cari_grup_id" => "required|gt:0"
        ]);

        $res = Cari::insert([
            "ad" => $req->ad,
            "telefon" => $req->telefon,
            "adres" => $req->adres,
            "ogrenciler" => json_encode($req->ogrenciler),
            "cari_grup_id" => $req->cari_grup_id,
            "vergi_no" => $req->vergi_no,
            "vergi_daire" => $req->vergi_daire,
            "mail" => $req->mail,
            "web_adresi" => $req->web_adresi,

        ]);
        return $this->resSuccess($res, "Cari Eklemesi Başarılı");
    }
    public function detail($id)
    {
        return $this->resSuccess(Cari::where("id", $id)->first()->getBilgiler());
    }
    public function delete($id)
    {
        return $this->resSuccess(Cari::where("id", $id)->update(["durum" => 0]), "Cari Başarıyla Silindi!");
    }
    public function get()
    {
        $goTo = [];
        foreach (Cari::where("durum", 1)->get() as $data) {
            $goTo[] = [
                "id" => $data->id,
                "ad" => $data->ad,
                "telefon" => $data->telefon
            ];
        }
        return $this->resSuccess($goTo);
    }
    public function getSelect()
    {
        $goTo = [];
        foreach (Cari::where("durum", 1)->get() as $data) {
            $goTo[] = $data->getSelect();
        }
        return $this->resSuccess($goTo);
    }
    public function getUpdate($id)
    {
        $grup = Cari::where(["durum" => 1, "id" => $id])->first();
        return $this->resSuccess($grup);
    }

    public function getEkstre($id, $baslangic = 0, $bitis = 0, Request $request)
    {
        $cari = Cari::where("id", $id)->first();
        $yilbasi = date('Y-01-01');
        $yilsonu = date('Y-12-31');
        $tarihGeldi = 0;
        $para_birimleri = ParaBirim::get();
        $para_birimleri_list = ParaBirim::get();
        if ($baslangic && $bitis) {
            $yilbasi = $baslangic;
            $tarihGeldi = $baslangic . "/" . $bitis;
            $yilsonu = $bitis;
        }
        $ekstre = CariEkstre::where(['cari_id' => $cari->id, 'is_deleted' => 0])->orderBy('islem_tarih', 'desc')->whereBetween("islem_tarih", [$yilbasi . " 00:00:00", $yilsonu . " 23:59:59"])->get();

        if ($request->parabirim_select) {
            $ekstre = CariEkstre::where(['cari_id' => $cari->id, 'para_birimi' => $request->parabirim_select, 'is_deleted' => 0])->orderBy('created_at', 'desc')->whereBetween("created_at", [$yilbasi . " 00:00:00", $yilsonu . " 23:59:59"])->get();
            $para_birimleri = ParaBirim::where("id", $request->parabirim_select)->get();
        }
        $ekstreGo = [];
        foreach ($ekstre as $ekstreData) {
            $ekstreGo[] = [
                "islem_no" => sprintf("%05s", $ekstreData->id),
                "islem_tutar" => $ekstreData->islem_tutar . $ekstreData->getParaBirimKod(),
                "islem_personel" => $ekstreData->getPersonel(),
                "hesap" => $ekstreData->getHesap(),
                "islem_turu" => $ekstreData->islem_turu,
                "islem_turu_generic" => $ekstreData->getIslemTurGeneric(),
                "islem_tarihi" => date("d.m.Y H:i", strtotime($ekstreData->islem_tarih)),
                "hareket_turu_str" => $ekstreData->hareket_turu == 1 ? "EKSTRE.BORC" : "EKSTRE.ODEME",
                "hareket_turu_int" => $ekstreData->hareket_turu,
                "borc_tutar" => $ekstreData->getBorcTutar(),
                "odeme_tutar" => $ekstreData->getOdemeTutar(),
            ];
        }
        $ekstre = $ekstreGo;
        // Borçlar
        $sum_price_debt = array();
        foreach ($para_birimleri as $para_birimi) {
            $sum_price_debt[$para_birimi->kod] = CariEkstre::where(['cari_id' => $cari->id, 'para_birimi' => $para_birimi->id, 'hareket_turu' => 1, 'is_deleted' => 0]) // hareket_turu = 1 => borç, 2 => ödeme
                ->whereBetween("islem_tarih", [$yilbasi . " 00:00:00", $yilsonu . " 23:59:59"])
                ->select(\DB::raw('SUM(islem_tutar) as total_price'))->first()->total_price;
        }
        // Ödemeler
        $sum_price_payment = array();
        foreach ($para_birimleri as $para_birimi) {
            $sum_price_payment[$para_birimi->kod] = CariEkstre::where(['cari_id' => $cari->id, 'para_birimi' => $para_birimi->id, 'hareket_turu' => 2, 'is_deleted' => 0])
                ->whereBetween("islem_tarih", [$yilbasi . " 00:00:00", $yilsonu . " 23:59:59"])
                ->select(\DB::raw('SUM(islem_tutar) as total_price'))->first()->total_price;
        }
        // Toplam
        $sum_price = array();
        foreach ($para_birimleri as $para_birimi) {
            $sum_price[$para_birimi->kod] = $sum_price_payment[$para_birimi->kod] - $sum_price_debt[$para_birimi->kod];
        }
        $bakiye = 0;
        $bakiyeArr = [];
        if (isset($request->parabirim_select)) {
            $ekstreBakiye = CariEkstre::where(['cari_id' => $cari->id, 'para_birimi' => $request->parabirim_select, 'is_deleted' => 0])->orderBy('islem_tarih', 'asc')->whereBetween("islem_tarih", [$yilbasi . " 00:00:00", $yilsonu . " 23:59:59"])->get();
            foreach ($ekstreBakiye as $ekstre1) {
                if ($ekstre1->hareket_turu == 1)
                    $bakiyeArr[] = $bakiye -= $ekstre1->islem_tutar;
                elseif ($ekstre1->hareket_turu == 2)
                    $bakiyeArr[] = $bakiye += $ekstre1->islem_tutar;
            }
        }
        $tarihler = $this->get2YilaKadarTarihler();
        return $this->resSuccess(compact(['tarihler', 'bakiyeArr', 'tarihGeldi', 'para_birimleri_list', 'cari', 'ekstre', 'para_birimleri', 'sum_price_debt', 'sum_price_payment', 'sum_price']));
    }
    public function odemeAl(Request $req)
    {
        CariEkstre::create([
            "islem_turu" => $req->odeme_turu,
            "hesap_id" => $req->hesap_id,
            "cari_id" => $req->cari_id,
            "islem_id" => 0,
            "para_birimi" => $req->para_birimi,
            "islem_tutar" => $req->tutar,
            "personel_id" => $req->tahsil_eden_personel,
            "islem_tarih" => $req->odeme_tarihi,
            "hareket_turu" => 2,
        ]);
        if ($req->odeme_turu > 1) {
            CariCekSenet::create([
                "cari_id" => $req->cari_id,
                "para_birimi" => $req->para_birimi,
                "tutar" => $req->tutar,
                "tur" => $req->odeme_turu,
                "numara" => $req->numara,
                "islem_tarihi" => $req->odeme_tarihi,
                "baslangic_tarihi" => $req->baslangic_tarihi,
                "vade_tarihi" => $req->vade_tarihi,
                "islem_aciklama" => 0,
            ]);
        } else {
            $this->hesapIslemiYap($req->hesap_id, $req->tutar, $req->para_birimi, 2, $req->cari_id);
        }
    }
    public function getCekSenetler($id)
    {
        $cekSenetler = [];
        foreach (CariCekSenet::where("cari_id", $id)->get() as $cekSenet) {
            $cekSenetler[] = [
                "id" => $cekSenet->id,
                "tur" => $cekSenet->tur,
                "no" => $cekSenet->numara,
                "tutar" => $cekSenet->tutar . " " . ParaBirim::where("id", $cekSenet->para_birimi)->first()->kod,
                "baslangic" => date("d.m.Y", strtotime($cekSenet->baslangic_tarihi)),
                "vade" => date("d.m.Y", strtotime($cekSenet->vade_tarihi)),
                "islem_tarihi" => date("d.m.Y", strtotime($cekSenet->islem_tarihi)),
            ];
        }
        return $this->resSuccess($cekSenetler);
    }

    public function update(Request $req)
    {
        $cari = Cari::find($req->id);
        $data = $req->all();
        $req->validate([
            "ad" => "required",
            "cari_grup_id" => "required|gt:0"
        ]);

        $res = $cari->update([
            "ad" => $req->ad,
            "telefon" => $req->telefon,
            "adres" => $req->adres,
            "ogrenciler" => json_encode($req->ogrenciler),
            "cari_grup_id" => $req->cari_grup_id,
            "vergi_no" => $req->vergi_no,
            "vergi_daire" => $req->vergi_daire,
            "mail" => $req->mail,
            "web_adresi" => $req->web_adresi,

        ]);
        return $this->resSuccess($res, "Cari Güncellemesi Başarılı");
    }
}
