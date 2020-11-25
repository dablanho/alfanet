<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Personel extends Model
{
    protected $table = "personeller";
    protected $guarded = [];

    public function getBilgiler()
    {
        return [
            "id" => $this->id,
            "ad" => $this->ad,
            "email" => $this->getUser()->email ?? "-",
            "telefon" => $this->telefon,
            "grup" => $this->getGrup(),
            "country" => $this->getCountry(),
            "city" => $this->getCity(),
            "district" => $this->getDistrict(),
            "street" => $this->getStreet(),
            //"okullar" => $this->getOkullar(),
        ];
    }
    public function getSelect(){
        return [
            "ad" => $this->ad,
            "id" => $this->id
        ];
    }
    public function getCountry()
    {
        try {
            return $this->belongsTo(Country::class, "country_id")->select(['id','name'])->first();
        } catch (\Throwable $th) {
            return "";
        }
    }
    public function getCity()
    {
        try {
            return $this->belongsTo(City::class, "city_id")->select(['id','name'])->first();
        } catch (\Throwable $th) {
            return "";
        }
    }
    public function getDistrict()
    {
        try {
            return $this->belongsTo(CityDistrict::class, "citydistrict_id")->select(['id','ilce'])->first();
        } catch (\Throwable $th) {
            return "";
        }
    }
    public function getStreet()
    {
        try {
            return $this->belongsTo(CityDistrict::class, "citydistrict_id")->select(['id','mahalle'])->first();
        } catch (\Throwable $th) {
            return "";
        }
    }
    public function getUser()
    {
        return $this->belongsTo(User::class, "user_id")->first();
    }
    public function getGrup()
    {
        $grup = $this->belongsTo(PersonelGrup::class, "grup_id")->select(['id','ad'])->first();
        if(!empty($grup->id))
            return $grup;
        return collect([]);
    }
    public function getGrupAd()
    {
        $grup = $this->belongsTo(PersonelGrup::class, "grup_id")->select(['id','ad'])->first();
        return !empty($grup) ? $grup->ad : " - ";
    }
    public function getOkullar()
    {
        return Okul::whereIn("id", json_decode($this->okullar))->get();
    }
    public function getAd() {
        return $this->ad;
    }
}
