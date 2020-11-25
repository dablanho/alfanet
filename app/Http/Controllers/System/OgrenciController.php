<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\GlobalController;
use App\Models\Makbuz;
use App\Models\OgrenciDosya;
use App\Models\Ogrenciler;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OgrenciController extends GlobalController
{
    public function addStudent(Request $req)
    {
        $data = $req->validate([
            "ad" => "required",
            "okul" => "required|numeric",
            "tc" => "numeric|nullable",
            "dogum_tarihi" => "date|nullable",
            "telefon" => "numeric|nullable",
            "enlem" => "numeric|nullable",
            "boylam" => "numeric|nullable",
            "servis_id" => "required|numeric",
        ]);

        $res = Ogrenciler::insert([
            "ad" => $data["ad"],
            "okul" => $data["okul"],
            "tc" => $req->tc,
            "dogum_yeri" => $req->dogum_yeri,
            "kan_grubu" => $req->kan_grubu,
            "koltuk_no" => $req->koltuk_no,
            "cinsiyet" => $req->cinsiyet,
            "dogum_tarihi" => $req->dogum_tarihi,
            "country_id" => $req->country,
            "city_id" => $req->city,
            "citydistrict_id" => $req->districtAndStreet,
            "telefon" => $req->telefon,
            "veliler" => json_encode($req->veliler),
            "enlem" => $req->lat,
            "boylam" => $req->lng,
            "servis_id" => $req->servis_id
        ]);
        return $this->resSuccess($res, "Öğrenci Eklemesi Başarılı");
    }
    public function getStudent($id)
    {
        return $this->resSuccess(Ogrenciler::where("id", $id)->first()->getBilgiler());
    }
    public function deleteStudent($id)
    {
        return $this->resSuccess(Ogrenciler::where("id", $id)->update(["durum" => 0]), "Öğrenci Başarıyla Silindi!");
    }
    public function getStudents($locations)
    {
        $goTo = [];
        foreach (Ogrenciler::where("durum", 1)->get() as $key=>$data) {
            $goTo[$key]["id"] = $data->id;
            $goTo[$key]["name"] = $data->ad;
            $goTo[$key]["telefon"] = $data->telefon;
            $goTo[$key]["okul"] = !empty($data->getOkul()) ? $data->getOkul()->ad : "-";
            $goTo[$key]["place"] = $data->getCity()." / ".$data->getDistrict();
            if(isset($locations) && $locations == "getlocations") {
                $goTo[$key]["enlem"] = $data->enlem;
                $goTo[$key]["boylam"] = $data->boylam;
            }
        }

        return $this->resSuccess($goTo);
    }
    public function getSelect()
    {
        $goTo = [];
        foreach (Ogrenciler::where("durum", 1)->get() as $data) {
            $goTo[] = $data->getSelect();
        }
        return $this->resSuccess($goTo);
    }
    public function getUpdate($id){
        $ogr = Ogrenciler::where(["durum"=>1, "id"=>$id])->first();
        $ogr['okul'] = $ogr->getOkul();
        $ogr['district'] = $ogr->getDistrict();
        return $this->resSuccess($ogr);
    }

    public function updateStudent(Request $req)
    {
        $student = Ogrenciler::where('id', $req->id)->first();
        $data = $req->validate([
            "ad" => "required",
            "okul.id" => "required|numeric",
            "tc" => "numeric|nullable",
            "dogum_tarihi" => "date|nullable",
            "telefon" => "numeric|nullable",
            "enlem" => "numeric|nullable",
            "boylam" => "numeric|nullable",
            "servis_id" => "required|numeric",
        ]);

        $res = $student->update([
            "tc" => $req->tc,
            "dogum_yeri" => $req->dogum_yeri,
            "kan_grubu" => $req->kan_grubu,
            "koltuk_no" => $req->koltuk_no,
            "cinsiyet" => $req->cinsiyet,
            "dogum_tarihi" => $req->dogum_tarihi,
            "ad" => $data["ad"],
            "okul" => $data["okul"]["id"],
            "country_id" => $req->country,
            "city_id" => $req->city,
            "citydistrict_id" => $req->districtAndStreet,
            "telefon" => $req->telefon,
            "veliler" => json_encode($req->veliler),
            "enlem" => $req->lat,
            "boylam" => $req->lng,
            "servis_id" => $req->servis_id
        ]);
        return $this->resSuccess($res, "Öğrenci Eklemesi Başarılı");
    }

    public function getFiles($ogrenci_id) {
        $dosyalar = OgrenciDosya::where(["ogrenci_id" => $ogrenci_id, "gosterim" => 1])->get();
        $arr = [];
        foreach ($dosyalar as $dosya) {
            $arr[]['id'] = $dosya->id;
            $arr[]['url'] = $dosya->url;
            $arr[]['ogrenci'] = $dosya->ogrenciAd();
        }
        return $this->resSuccess($dosyalar);
    }

    public function createFile(Request $request) {
        $ogrenci = Ogrenciler::find($request->ogrenci_id);
        $request->validate([
            "dosya" => "required",
            "ad" => "required",
        ]);
        $file = $request->file('dosya');
        $firma = $request->user()->getFirmaSema();
        $ogrPath = Str::slug($ogrenci->ad . $ogrenci->id);
        $rootPath = '/ogrenci/'.$firma.'/dosyalar/' . $ogrPath . '/';
        $fileName = $request->ad."-".date("Y-m-d-H-i-s");
        $dosyaURL = $this->addFile($file, $rootPath, $fileName);
        return $this->resSuccess(OgrenciDosya::create(["ad" => $request->ad, "url" => $dosyaURL, "ogrenci_id" => $request->ogrenci_id]));
    }

    public function deleteFile(Request $request)
    {
        $ogrDosya = OgrenciDosya::find($request->id);
        $ogrDosya->gosterim = 0;
        $ogrDosya->save();
        return $this->resSuccess($ogrDosya);
    }

    public function getMakbuzlar($id) {
        $datas = [];
        foreach (Makbuz::where("ogr_id",$id)->with(["hesap","personel","paraBirimi"])->get() as $data){
            $datas[] = $data->getListBilgiler();
        }
        return $this->resSuccess($datas);
    }

    public function getForManuelRapor(Request $request) {
        $servis = $request->servis;
        $okul = $request->okul;
        $fieldsToShow = $request->fieldsToShow;
        $query = Ogrenciler::where(['okul'=>$okul, 'servis_id' => $servis, 'durum' => 1])->select($fieldsToShow)->get();
        $renderData = [];
        foreach ($query as $key=>$data) {
            isset($data->id) ? $renderData[$key]["id"] = $data->id : null;
            isset($data->ad) ? $renderData[$key]["ad"] = $data->ad : null;
            isset($data->okul) ? $renderData[$key]["okul_ad"] = !empty($data->getOkul()) ? $data->getOkul()->ad : "-" : null;
            isset($data->servis_id) ? $renderData[$key]["servis_ad"] = !empty($data->getServis()) ? $data->getServis()->plaka : "-" : null;
            isset($data->tc) ? $renderData[$key]["tc"] = $data->tc : null;
            isset($data->telefon) ? $renderData[$key]["telefon"] = $data->telefon : null;
        }
        return $this->resSuccess($renderData);
    }
}
