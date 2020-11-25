<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GlobalController;
use App\Models\Arac;
use App\Models\AracDosya;
use App\Models\Markalar;
use App\Models\Modeller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AracController extends GlobalController
{
    public function addArac(Request $req)
    {
        $req->validate([
            "sofor_id" => "required | gt:0",
            "model_yili" => "required",
            "marka_kodu" => "required",
            "model_id" => "required",
            "plaka" => "required",
        ]);
        return $this->resSuccess(Arac::insert($req->all()));
    }
    public function getSelect()
    {
        $goTo = [];
        foreach (Arac::where("durum", 1)->get() as $data) {
            $goTo[] = $data->getSelect();
        }
        return $this->resSuccess($goTo);
    }
    public function getAraclar()
    {
        $goTo = [];
        foreach (Arac::where("durum", 1)->get() as $arac) {
            $goTo[] = $arac->getListBilgiler();
        }
        return $this->resSuccess($goTo);
    }
    public function getArac($id)
    {
        return $this->resSuccess(Arac::where("id", $id)->first()->getBilgiler());
    }
    public function deleteArac($id)
    {
        return $this->resSuccess(Arac::where("id", $id)->update(["durum" => 0]), "Araç Başarıyla Silindi!");
    }
    public function getMarkalar()
    {
        return $this->resSuccess(Markalar::get());
    }
    public function getModeller($id)
    {
        return $this->resSuccess(Modeller::where("marka_kodu", $id)->get());
    }

    public function update(Request $request) {
        $arac = Arac::find($request->id);
        $data = $request->all();
        $request->validate([
            "sofor_id" => "required | gt:0",
            "model_yili" => "required",
            "marka_kodu" => "required",
            "model_id" => "required",
            "plaka" => "required",
        ]);
        $update = $arac->update($data);
        return $this->resSuccess($update);
    }


     public function getFiles($arac_id) {
        $dosyalar = AracDosya::where(["arac_id" => $arac_id, "gosterim" => 1])->get();
        $arr = [];
        foreach ($dosyalar as $dosya) {
            $arr[]['id'] = $dosya->id;
            $arr[]['url'] = $dosya->url;
            $arr[]['arac'] = $dosya->getArac();
        }
        return $this->resSuccess($dosyalar);
    }

    public function createFile(Request $request) {
        $arac = Arac::find($request->arac_id);
        $request->validate([
            "dosya" => "required",
            "ad" => "required",
        ]);
        $file = $request->file('dosya');
        $firma = $request->user()->getFirmaSema();
        $arcPath = Str::slug($arac->plaka . $arac->id);
        $rootPath = '/araclar/'.$firma.'/dosyalar/' . $arcPath . '/';
        $fileName = $request->ad."-".date("Y-m-d-H-i-s");
        $dosyaURL = $this->addFile($file, $rootPath, $fileName);
        return $this->resSuccess(AracDosya::create(["ad" => $request->ad, "url" => $dosyaURL, "arac_id" => $request->arac_id]));
    }

    public function deleteFile(Request $request)
    {
        $ogrDosya = AracDosya::find($request->id);
        $ogrDosya->gosterim = 0;
        $ogrDosya->save();
        return $this->resSuccess($ogrDosya);
    }

}
