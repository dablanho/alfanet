<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GlobalController;
use App\Models\FiyatlandirmaTuru;
use Illuminate\Http\Request;

class FiyatlandirmaController extends GlobalController
{
    public function add(Request $req)
    {
        $data = $req->validate([
            "ad" => "required",
            "oran" => "required"
        ]);

        $res = FiyatlandirmaTuru::insert([
            "ad" => $data["ad"],
            "oran" => $data["oran"],
            "created_at" => date("Y-m-d H:i:s")
        ]);
        return $this->resSuccess($res, "FiyatlandirmaTuru Eklemesi Başarılı");
    }

    public function delete($id)
    {
        return $this->resSuccess(FiyatlandirmaTuru::where("id", $id)->update(["durum" => 0]), "FiyatlandirmaTuru Başarıyla Silindi!");
    }
    public function get()
    {
        return $this->resSuccess(FiyatlandirmaTuru::where("durum", 1)->get());
    }
    public function getSelect()
    {
        $goTo = [];
        
        foreach (FiyatlandirmaTuru::where("durum", 1)->get() as $data) {
            $goTo[] = $data->getSelect();
        }
        return $this->resSuccess($goTo);
    }
    public function getUpdate($id)
    {
        $ogr = FiyatlandirmaTuru::where(["durum" => 1, "id" => $id])->first();
        return $this->resSuccess($ogr);
    }
}
