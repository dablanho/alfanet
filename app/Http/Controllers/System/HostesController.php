<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\GlobalController;
use App\Models\Hostes;

class HostesController extends GlobalController
{
    public function add(Request $req)
    {
        $data = $req->validate([
            "ad" => "required",
            "maas" => 'nullable|numeric',
            'para_birimi' => 'required_with:maas|numeric|nullable',
            "dogum_tarihi" => "nullable|date",
            "telefon" => "nullable|numeric",
            "tc" => "nullable|numeric"
        ]);

        $res = Hostes::insert([
            "tc" => $req->tc,
            "dogum_yeri" => $req->dogum_yeri,
            "dogum_tarihi" => $req->dogum_tarihi,
            "ad" => $data["ad"],
            "okul" => $req->okul,
            "adres" => $req->adres,
            "telefon" => $req->telefon,
            "medeni_hali" => $req->medeni_hali,
            "ogr_durum" => $req->ogr_durum,
            "servis" => $req->servis,
            "maas" => $req->maas,
        ]);
        return $this->resSuccess($res, "Hostes Eklemesi Başarılı");
    }
    public function detail($id)
    {
        return $this->resSuccess(Hostes::where("id", $id)->first()->getBilgiler());
    }
    public function delete($id)
    {
        return $this->resSuccess(Hostes::where("id", $id)->update(["durum" => 0]), "Hostes Başarıyla Silindi!");
    }
    public function get()
    {
        $goTo = [];
        foreach (Hostes::where("durum", 1)->get() as $data) {
            $goTo[] = $data->getListBilgiler();
        }
        return $this->resSuccess($goTo);
    }
    public function getSelect()
    {
        $goTo = [];
        foreach (Hostes::where("durum", 1)->get() as $data) {
            $goTo[] = $data->getSelect();
        }
        return $this->resSuccess($goTo);
    }
    public function getUpdate($id)
    {
        $ogr = Hostes::where(["durum" => 1, "id" => $id])->first();
        $ogr['okul'] = $ogr->getOkul();
        return $this->resSuccess($ogr);
    }

    public function update(Request $request) {
        $hostes = Hostes::find($request->id);
        $data = $request->all();
        $request->validate([
            "ad" => "required",
            "maas" => 'nullable|numeric',
            'para_birimi' => 'required_with:maas|numeric|nullable',
            "dogum_tarihi" => "nullable|date",
            "telefon" => "nullable|numeric",
            "tc" => "nullable|numeric"
        ]);
        $update = $hostes->update([
            'ad' => $request->ad,
            'tc' => $request->tc,
            'dogum_yeri' => $request->dogum_yeri,
            'medeni_hali' => $request->medeni_hali,
            'telefon' => $request->telefon,
            'ogr_durum' => $request->ogr_durum,
            'adres' => $request->adres,
            'dogum_tarihi' => $request->dogum_tarihi,
            'maas' => $request->maas,
            'para_birimi' => $request->para_birimi
        ]);
        if(!empty($request->okul)){
            $hostes->update([
                'okul' => $request->okul
            ]);
        }
        if(!empty($request->servis)){
            $hostes->update([
                'servis' => $request->servis
            ]);
        }
        return $this->resSuccess($update, "Hostes Güncellemesi Başarılı");
    }
}
