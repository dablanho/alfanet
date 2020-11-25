<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hesap extends Model
{
    protected $table = "hesaplar";

    public function getBilgiler(){
        return [
            "hesap" => $this,
            "para_birimi" => $this->belongsTo(ParaBirim::class,"para_birimi")->first(),
            "hesap_hareket" => HesapHareket::where("hesap_id",$this->id)->get(),
        ];
    }

    public function getSelect(){
        return [
            "ad" => $this->hesap_ad,
            "id" => $this->id,
            "para_birimi_id" => $this->para_birimi
        ];
    }

    public function getAd(){
        return $this->hesap_ad;
    }
    public function getBanka(){
        return $this->banka_ad;
    }
}
