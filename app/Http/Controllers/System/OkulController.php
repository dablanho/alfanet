<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GlobalController;
use App\Models\Okul;
use Illuminate\Http\Request;

class OkulController extends GlobalController
{
    public function addSchool(Request $req)
    {
        $data = $req->validate([
            "okulAdi" => "required",
            "okulKodu" => "nullable",
            "mudur" => "nullable",
            "telefon" => "nullable",
            "adres" => "nullable",
            "lat" => "numeric|nullable",
            "lng" => "numeric|nullable",
        ]);
        $data = Okul::insert([
            "ad" => $data["okulAdi"],
            "kod" => $data["okulKodu"],
            "enlem" => $data["lat"],
            "boylam" => $data["lng"],
            "mudur" => $data["mudur"],
            "telefon" => $data["telefon"],
            "adres" => $data["adres"],
        ]);
        return $this->resSuccess($data, "Okul Eklemesi Başarılı");
    }

    public function getAllSchool()
    {
        $datas = [];
        foreach (Okul::where("durum", 1)->get() as $data) {
            $datas[] = [
                "id" => $data->id,
                "ad" => $data->ad,
                "kod" => $data->kod,
            ];
        }
        return $this->resSuccess($datas);
    }

    public function getSchool($id)
    {
        return $this->resSuccess(Okul::where(["durum" => 1, "id" => $id])->with("ogrenci")->first());
    }

    public function updateSchool(Request $req)
    {
        $data = $req->validate([
            "okulAdi" => "required",
            "okulKodu" => "nullable",
            "mudur" => "nullable",
            "telefon" => "nullable",
            "adres" => "nullable",
            "lat" => "numeric|nullable",
            "lng" => "numeric|nullable",
        ]);
        try {
            $data = Okul::where("id", $req->id)->update([
                "ad" => $data["okulAdi"],
                "kod" => $data["okulKodu"],
                "enlem" => $data["lat"],
                "boylam " => $data["lng"],
                "mudur" => $data["mudur"],
                "telefon" => $data["telefon"],
                "adres" => $data["adres"],
            ]);
            return $this->resSuccess($data, "Okul Güncellemesi Başarılı");
        } catch (\Throwable $th) {
            return $this->resError($th);
        }
    }

    public function deleteSchool(Request $req)
    {
        $id = $req->id;
        return $this->resSuccess(Okul::where("id", $id)->update(["durum" => 0]), "Okul başarı ile silindi.");
    }

    public function update(Request $request)
    {
        $data = $request->all();
        $okul = Okul::find($request->id);
        $request->validate([
            "okulAdi" => "required",
            "okulKodu" => "nullable",
            "mudur" => "nullable",
            "telefon" => "nullable",
            "adres" => "nullable",
            "lat" => "numeric|nullable",
            "lng" => "numeric|nullable",
        ]);
        $res = $okul->update([
            "ad" => $data["okulAdi"],
            "kod" => $data["okulKodu"],
            "enlem" => $data["lat"],
            "boylam" => $data["lng"],
            "mudur" => $data["mudur"],
            "telefon" => $data["telefon"],
            "adres" => $data["adres"],
        ]);
        return $this->resSuccess($res, "Okul Güncellemesi Başarılı");
    }

    public function getForTumOgrencilerManuelRapor()
    {
        $goTo = [];
        foreach (Okul::where("durum", 1)->get() as $data) {
            $goTo[] = [
                'id' => $data->id,
                'ad' => $data->ad,
                'servisler' => $data->getServisler,
            ];
        }
        return $this->resSuccess($goTo);
    }
}
