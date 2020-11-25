<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GlobalController;
use App\Models\CariGrup;
use Illuminate\Http\Request;

class CariGrupController extends GlobalController
{
    public function add(Request $req)
    {
        $data = $req->validate([
            "ad" => "required"
        ]);

        $res = CariGrup::insert([
            "ad" => $req->ad,
        ]);
        return $this->resSuccess($res, "Cari Grup Eklemesi Başarılı");
    }
    public function detail($id)
    {
        return $this->resSuccess(CariGrup::where("id", $id)->first());
    }
    public function delete($id)
    {
        return $this->resSuccess(CariGrup::where("id", $id)->update(["durum" => 0]), "Cari Grup Başarıyla Silindi!");
    }
    public function get()
    {
        return $this->resSuccess(CariGrup::where("durum",1)->get());
    }
    public function getSelect()
    {
        $goTo = [];
        foreach (CariGrup::where("durum", 1)->get() as $data) {
            $goTo[] = $data->getSelect();
        }
        return $this->resSuccess($goTo);
    }
    public function getUpdate($id)
    {
        $grup = CariGrup::where(["durum" => 1, "id" => $id])->first();
        return $this->resSuccess($grup);
    }
}
