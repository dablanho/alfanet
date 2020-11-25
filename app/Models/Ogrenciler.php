<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ogrenciler extends Model
{
    protected $table = "ogrenciler";
    protected $guarded = [];

    public function getBilgiler()
    {
        return [
            "id" => $this->id,
            "name" => $this->ad,
            "telefon" => $this->telefon,
            "tc" => $this->tc,
            "kan_grubu" => $this->kan_grubu,
            "dogum_yeri" => $this->dogum_yeri,
            "dogum_tarihi" => date("d.m.Y", strtotime($this->dogum_tarihi)),
            "dogum_tarihi_original" => $this->dogum_tarihi,
            "koltuk_no" => $this->koltuk_no,
            "cinsiyet" => $this->cinsiyet,
            "okul_id" => !empty($this->getOkul()) ? $this->getOkul()->id : 0,
            "okul" => !empty($this->getOkul()) ? $this->getOkul()->ad : "-",
            "okul_obj" => $this->getOkul(),
            "city_id" => $this->city_id,
            "citydistrict_id" => $this->citydistrict_id,
            "country_id" => $this->country_id,
            "country" => $this->getCountry(),
            "city" => $this->getCity(),
            "district" => $this->getDistrict(),
            "street" => $this->getStreet(),
            "enlem" => $this->enlem,
            "boylam" => $this->boylam,
            "veliler" => $this->getVeliler(),
            "servis_id" => $this->servis_id,
            "servis" => Arac::where("id",$this->servis_id)->first()
        ];
    }
    public function getSelect()
    {
        return [
            "id" => $this->id,
            "name" => $this->ad,
        ];
    }
    public function getOkul()
    {
        $okul = $this->belongsTo(Okul::class, "okul")->first();
        if(isset($okul))
            return $okul;
        return [];
    }
    public function getCountry()
    {
        return $this->belongsTo(Country::class, "country_id")->first()->name;
        /* try {
        } catch (\Throwable $th) {
            return "";
        } */
    }
    public function getCity()
    {
        try {
            return $this->belongsTo(City::class, "city_id")->first()->name;
        } catch (\Throwable $th) {
            return "";
        }
    }
    public function getDistrict()
    {
        try {
            return $this->belongsTo(CityDistrict::class, "citydistrict_id")->first()->ilce;
        } catch (\Throwable $th) {
            return "";
        }
    }
    public function getStreet()
    {
        try {
            return $this->belongsTo(CityDistrict::class, "citydistrict_id")->first()->mahalle;
        } catch (\Throwable $th) {
            return "";
        }
    }
    public function getVeliIDs()
    {
        try {
            $return = [];
            foreach (json_decode($this->veliler) as $veli) {
                $return[] = $veli->id;
            }
            return $return;
        } catch (\Throwable $th) {
            return [];
        }
    }
    public function getVeliler()
    {
        if (!empty($this->veliler))
            return Veliler::whereIn("id", $this->getVeliIDs())->get();
        return [];
    }

    public function getAd() {
        if(!empty($this->ad))
            return $this->ad;
        return "-";
    }
    public function getSearchAd() {
        return $this->getAd()." (Öğrenci)";
    }

    public function getSearchUrl() {
        return "/ogrenciler/detay/".$this->id;
    }

    public function getServis() {
        return Arac::where("id",$this->servis_id)->first();
    }
}
