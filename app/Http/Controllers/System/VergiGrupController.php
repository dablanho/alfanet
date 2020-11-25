<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GlobalController;
use App\Models\VergiGrup;
use Illuminate\Http\Request;

class VergiGrupController extends GlobalController
{
    public function add(Request $req)
    {
        $data = $req->validate([
            "ad" => "required",
            "oran" => "required"
        ]);

        $res = VergiGrup::insert([
            "ad" => $data["ad"],
            "oran" => $data["oran"],
            "created_at" => date("Y-m-d H:i:s")
        ]);
        return $this->resSuccess($res, "VergiGrup Eklemesi Başarılı");
    }

    public function delete($id)
    {
        return $this->resSuccess(VergiGrup::where("id", $id)->update(["durum" => 0]), "VergiGrup Başarıyla Silindi!");
    }
    public function get()
    {
        return $this->resSuccess(VergiGrup::where("durum", 1)->get());
    }
    public function getSelect()
    {
        $goTo = [];
        foreach (VergiGrup::where("durum", 1)->orderBy("oran","ASC")->get() as $data) {
            $goTo[] = $data->getSelect();
        }
        return $this->resSuccess($goTo);
    }
    public function getUpdate($id)
    {
        $ogr = VergiGrup::where(["durum" => 1, "id" => $id])->first();
        return $this->resSuccess($ogr);
    }
}
