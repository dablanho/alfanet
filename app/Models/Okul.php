<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Okul extends Model
{
    protected $table = "okullar";
    protected $guarded = [];

    public function ogrenci(){
        return $this->hasMany(Ogrenciler::class,"okul")->where("durum",1);
    }

    public function getAd() {
        if(!empty($this->ad))
            return $this->ad;
        return "-";
    }
    public function getSearchAd() {
        return $this->getAd()." (Servis)";
    }

    public function getSearchUrl() {
        return "/okul/detay/".$this->id;
    }

    public function getServisler() {
        return $this->hasMany(AracOkul::class, 'okul_id')
            ->select(['servis_id as id', 'plaka as name'])->join('araclar', 'servis_id','araclar.id');
    }
}
