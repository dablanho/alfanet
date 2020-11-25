<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HesapHareket extends General
{
    protected $table = "hesap_hareketleri";
    protected $guarded = [];

    public static $tur = ["Belirtilmemiş", "Ödeme (-)", "Tahsilat (+)", "Personel Maaş Ödemesi", "Öğrenci Ödemesi"];
    public static $which_cari = ["Belirtilmemiş", "Cari Ödeme", "Cari Tahsilat", "Personel", "Öğrenci"];
    public function getInfos(){
        return  [
            "id" => $this->id,
            "cari" => $this->getCariGeneric(),
            "hesap_ad" => $this->getHesap()->getAd(),
            "hesap_banka" => $this->getHesap()->getBanka(),
            "islem_turu" => $this->getTur(),
            "tutar" => $this->getTutarGeneric(),
            "islem_tarihi" => $this->getIslemTarihi()
        ];
    }
    public function getTur(){

        return self::$tur[$this->islem_turu];
    }
    public function getTutar() {
        return $this->islem_tutari;
    }
    public function getTutarGeneric() {
        return $this->getTutar()." ".$this->getParaBirim()->kod;
    }
    public function getIslemTarihi(){
        return $this->formatDateTime($this->created_at);
    }
    public function getParaBirim(){
        return $this->belongsTo(ParaBirim::class,'para_birimi')->first();
    }
    public function getHesap(){
        return $this->belongsTo(Hesap::class, 'hesap_id')->first();
    }
    /*public function getFatura(){
        return $this->belongsTo(Fatura::class,'fatura_id')->first();
    }*/
    public function getCari(){
        if($this->islem_turu == 3)
            return $this->belongsTo(Personel::class,"cari_id")->first();
        else if($this->islem_turu == 4)
            return $this->belongsTo(Ogrenciler::class,"cari_id", "id")->first();
        else
            return $this->belongsTo(Cari::class,'cari_id')->first();
    }

    public function getCariGeneric() {
        return $this->getCari()->getAd()." (".self::$which_cari[$this->islem_turu].")";
    }


}
