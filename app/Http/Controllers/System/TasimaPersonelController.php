<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GlobalController;
use App\Models\TasimaPersonel;
use Illuminate\Http\Request;

class TasimaPersonelController extends GlobalController
{
    public function add(Request $req)
    {
        $data = $req->validate([
            "ad" => "required",
        ]);

        $res = TasimaPersonel::insert([
            "ad" => $data["ad"],
            "tc" => $req->tc,
            "dogum_tarihi" => $req->dogum_tarihi,
            "soyad" => $req->soyad,
            "adres" => $req->adres,
            "kan_grubu" => $req->kan_grubu,
            "enlem" => $req->enlem,
            "boylam" => $req->boylam,
            "telefon" => $req->telefon,
        ]);
        return $this->resSuccess($res, "TasimaPersonel Eklemesi Başarılı");
    }
    public function detail($id)
    {
        return $this->resSuccess(TasimaPersonel::where("id", $id)->first());
    }
    public function delete($id)
    {
        return $this->resSuccess(TasimaPersonel::where("id", $id)->update(["durum" => 0]), "TasimaPersonel Başarıyla Silindi!");
    }
    public function get()
    {
        $goTo = TasimaPersonel::where("durum", 1)->get();
        /*foreach (TasimaPersonel::where("durum", 1)->get() as $data) {
            $goTo[] = $data->getListBilgiler();
        }*/

        return $this->resSuccess($goTo);
    }
    public function getSelect()
    {
        $goTo = [];
        foreach (TasimaPersonel::where("durum", 1)->get() as $data) {
            $goTo[] = $data->getSelect();
        }
        return $this->resSuccess($goTo);
    }
    public function getUpdate($id)
    {
        $personel = TasimaPersonel::where(["durum" => 1, "id" => $id])->first();
        return $this->resSuccess($personel);
    }

    public function update(Request $req)
    {
        $TasimaPersonel = TasimaPersonel::find($req->id);
        $data = $req->all();
        $req->validate([
            "ad" => "required",
        ]);
        $update = $TasimaPersonel->update([
            "ad" => $data["ad"],
            "tc" => $req->tc,
            "dogum_tarihi" => $req->dogum_tarihi,
            "soyad" => $req->soyad,
            "adres" => $req->adres,
            "kan_grubu" => $req->kan_grubu,
            "enlem" => $req->enlem,
            "boylam" => $req->boylam,
            "telefon" => $req->telefon,
        ]);
        return $this->resSuccess($update, "TasimaPersonel Güncellemesi Başarılı");
    }
}
