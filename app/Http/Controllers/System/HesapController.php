<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GlobalController;
use App\Models\Hesap;
use Illuminate\Http\Request;

class HesapController extends GlobalController
{
    public function add(Request $req)
    {
        $data = $req->validate([
            "hesap_ad" => "required",
            "banka_ad" => "required",
            "para_birimi" => "required|gt:0",
        ]);
        $res = Hesap::insert([
            "hesap_ad" => $req->hesap_ad,
            "banka_ad" => $req->banka_ad,
            "iban_no" => $req->iban_no,
            "para_birimi" => $req->para_birimi,
            "bakiye" => $req->baslangic_bakiye ?? 0,
            "baslangic_bakiye" => $req->baslangic_bakiye ?? 0,
        ]);
        return $this->resSuccess($res, "Hesap Eklemesi Başarılı");
    }
    public function detail($id)
    {
        return $this->resSuccess(Hesap::where("id", $id)->first()->getBilgiler());
    }
    public function delete($id)
    {
        return $this->resSuccess(Hesap::where("id", $id)->update(["durum" => 0]), "Hesap Başarıyla Silindi!");
    }
    public function get()
    {
        $goTo = [];
        foreach (Hesap::where("durum", 1)->get() as $data) {
            $goTo[$data->id] = $data->getBilgiler();
        }
        return $this->resSuccess($goTo);
    }
    public function getSelect()
    {
        $goTo = [];
        foreach (Hesap::where("durum", 1)->get() as $data) {
            $goTo[] = $data->getSelect();
        }
        return $this->resSuccess($goTo);
    }
    public function getUpdate($id)
    {
        $ogr = Hesap::where(["durum" => 1, "id" => $id])->first();
        $ogr['okul'] = $ogr->getOkul();
        return $this->resSuccess($ogr);
    }
}
