<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GlobalController;
use App\Models\Arac;
use App\Models\AracOkul;
use Illuminate\Http\Request;

class AracOkulController extends GlobalController
{
    public function add(Request $req)
    {
        $req->validate([
            "servis_id" => "numeric|required",
            "okul_id" => "numeric|required",
        ]);
        if (AracOkul::where(["okul_id" => $req->okul_id, "servis_id" => $req->servis_id])->count() == 0)
            return $this->resSuccess(AracOkul::create(["okul_id" => $req->okul_id, "servis_id" => $req->servis_id]));
        else
            return response(['msg' => 'already-exists'], 422);
    }
    public function delete($id)
    {
        return $this->resSuccess(AracOkul::where("id", $id)->update(["gosterim" => 0]), "Arac Başarıyla Silindi!");
    }
    public function getAll()
    {
        return $this->resSuccess(AracOkul::where("gosterim", 1)->with("arac", "okul")->get());
    }
    public function getByOkul($id)
    {
        $goTo = [];
        $aracOkul = AracOkul::where(["gosterim" => 1, "okul_id" => $id])->get();
        foreach ($aracOkul as $value) {
            if (!empty($value->arac)) {
                $goTo[] = [
                    'id' => $value->id,
                    'plaka' => $value->arac->plaka,
                    'marka' => $value->arac->getMarkaAdi(),
                    'model' => $value->arac->getModelAdi(),
                    'sofor' => $value->arac->getSoforAdi(),
                    'arac_durumu' => $value->arac->arac_durumu,
                ];
            }
        }
        return $this->resSuccess($goTo);
    }
    public function getByServis($id)
    {
        return $this->resSuccess(AracOkul::where(["gosterim" => 1, "servis_id" => $id])->with("okul", "arac")->get());
    }
}
