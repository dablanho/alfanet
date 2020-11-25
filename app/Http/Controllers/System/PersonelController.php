<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GlobalController;
use App\Models\Personel;
use App\Models\PersonelGrup;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PersonelController extends GlobalController
{
    public function addStaff(Request $req)
    {

        $data = $req->validate([
            "ad" => "required",
            "email" => "required",
            "password" => "required",
            "country" => "required|gt:0",
            "grup" => "required",
        ]);
        $user = new User();
        $user->name = $data["ad"];
        $user->email = $data["email"];
        $user->password = \Hash::make($data["password"]);
        $user->firmasema = Auth::user()->firmasema;
        $user->save();
        $data = Personel::insert([
            "ad" => $data["ad"],
            "user_id" =>  $user->id,
            "okullar" => json_encode($req->okullar),
            "citydistrict_id" => $req->districtAndStreet,
            "city_id" => $req->city,
            "telefon" => $req->telefon,
            "grup_id" => $data["grup"],
            "country_id" => $data["country"],
        ]);
        return $this->resSuccess($data, "Personel Eklemesi Başarılı");
    }
    public function getAllStaffs(Request $req)
    {
        $goTo = [];
        foreach (Personel::where("durum", 1)->get() as $personel) {
            $goTo[] = [
                "id" => $personel->id,
                "ad" => $personel->ad,
                "telefon" => $personel->telefon,
                "email" => $personel->getUser()->email ?? "-",
                "grup" => $personel->getGrupAd(),
            ];
        }
        return $this->resSuccess($goTo);
    }
    public function getStaff($id)
    {
        return $this->resSuccess(Personel::where("id", $id)->first()->getBilgiler());
    }
    public function deleteStaff(Request $req)
    {
        $id = $req->id;
        return $this->resSuccess(Personel::where("id", $id)->update(["durum" => 0]), "Personel başarı ile silindi.");
    }
    public function addGroup(Request $req)
    {
        $data = $req->validate([
            "grupAdi" => "required"
        ]);
        $data = PersonelGrup::create(["ad" => $data["grupAdi"]]);
        return $this->resSuccess($data, "Personel Grubu Eklemesi Başarılı");
    }
    public function getAllGroups()
    {
        return $this->resSuccess(PersonelGrup::where("durum", 1)->get());
    }
    public function deleteGroup(Request $req)
    {
        $id = $req->id;
        return $this->resSuccess(PersonelGrup::where("id", $id)->update(["durum" => 0]), "Kullanıcı grubu başarı ile silindi.");
    }
    public function updateGroup(Request $req)
    {
        $id = $req->id;
        $ad = $req->ad;
        return $this->resSuccess(PersonelGrup::where("id", $id)->update(["ad" => $ad]), "Updated.");
    }
    public function updateStaff(Request $req)
    {
        $staff = Personel::where('id', $req->id)->first();
        $data = $req->validate([
            "ad" => "required",
            "email" => "required",
            "country" => "required|gt:0",
            "grup" => "required|gt:0",
        ]);
        $user = $staff->getUser();
        $user->name = $data["ad"];
        $user->email = $data["email"];
        if(!empty($data["password"])) {
            $req->validate([
                "password" => "sometimes|min:6",
            ]);
            $user->password = \Hash::make($req->password);
        }
        $user->save();
        $staff->update([
            "ad" => $data["ad"],
            "okullar" => json_encode($req->okullar),
            "citydistrict_id" => $req->districtAndStreet,
            "city_id" => $req->city,
            "telefon" => $req->telefon,
            "grup_id" => $data["grup"],
            "country_id" => $data["country"],
        ]);
        return $this->resSuccess($data, "Personel Güncelleme Başarılı");
    }

    public function getSelect(){
        $goTo = [];
        foreach(Personel::where("durum",1)->get() as $personel){
            $goTo[] = $personel->getSelect();
        }
        return $this->resSuccess($goTo);
    }
}
