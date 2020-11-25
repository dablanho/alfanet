<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\CityDistrict;
use App\Models\Country;
use Illuminate\Http\Request;

class AdressController extends GlobalController
{
    public function getCountries(){
        return $this->resSuccess(Country::get());
    }
    public function getCities($id){
        return $this->resSuccess(Country::where("id",$id)->first()->cities()->get());
    }
    public function getCityDistritcs($id){
        return $this->resSuccess(City::where("id",$id)->first()->districts()->select("ilce")->groupBy(["ilce"])->orderBy("ilce")->get());
    }
    public function getStreets($ilce){
        return $this->resSuccess(CityDistrict::where("ilce",$ilce)->orderBy("mahalle","ASC")->get());
    }
}
