<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GlobalController;
use App\Models\Veliler;
use Illuminate\Http\Request;

class VeliController extends GlobalController
{
    public function addVeli(Request $req)
    {
        $data = $req->validate([
            "ad" => "required"
        ]);
        $res = Veliler::insert([
            "ad" => $data["ad"],
            "telefon" => $req->telefon,
            "yakinlik" => $req->yakinlik,
            "ogrenciler" => json_encode($req->ogrenciler),
        ]);
        $this->resSuccess($res, "Veli Eklemesi Başarılı");
    }
    public function deleteVeli($id)
    {
        return $this->resSuccess(Veliler::where("id", $id)->update(["durum" => 0]), "Veli Başarıyla Silindi!");
    }
    public function getVeli($id)
    {
        return $this->resSuccess(Veliler::where("id", $id)->first()->getBilgiler());
    }
    public function getVeliler()
    {
        $goTo = [];
        foreach (Veliler::where("durum", 1)->get() as $data) {
            $goTo[] = $data->getListBilgiler();
        }
        return $this->resSuccess($goTo);
    }
    public function getSelect()
    {
        $goTo = [];
        foreach (Veliler::where("durum", 1)->get() as $data) {
            $goTo[] = $data->getSelect();
        }
        return $this->resSuccess($goTo);
    }
    public function update(Request $request) {
        $veli = Veliler::where('id',$request->id)->first();
        $data = $request->validate([
            "ad" => "required"
        ]);
        $res = $veli->update([
            "ad" => $data["ad"],
            "telefon" => $request->telefon,
            "yakinlik" => $request->yakinlik,
            "ogrenciler" => json_encode($request->ogrenciler),
        ]);
        $this->resSuccess($res, "Veli Eklemesi Başarılı");
    }
}
