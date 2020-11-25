<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CariEkstre extends Model
{
    protected $table = "cari_ekstreleri";
    protected $guarded = [];
    public static $odeme_turleri = ["Nakit", "Kredi Kartı", "Çek", "Senet"];
    public static $islem_turleri = ["Teklif Kabul Edildi","Borç"];
    public function getParaBirimKod()
    {
        return $this->belongsTo(ParaBirim::class, "para_birimi")->first()->kod;
    }
    public function getPersonel()
    {
        return $this->belongsTo(Personel::class, "personel_id")->first()->ad;
    }
    public function getHesap()
    {
        if ($this->hesap_id != 0)
            return $this->belongsTo(Hesap::class, "hesap_id")->first()->hesap_ad;
        else
            return "";
    }

    public function getBorcTutar()
    {
        if ($this->hareket_turu == 1) {
            return $this->islem_tutar . $this->getParaBirimKod();
        } else {
            return "";
        }
    }

    public function getOdemeTutar()
    {
        if ($this->hareket_turu == 2) {
            return $this->islem_tutar . $this->getParaBirimKod();
        } else {
            return "";
        }
    }

    public function getIslemTurGeneric()
    {
        if ($this->hareket_turu == 2) {
            return self::$odeme_turleri[$this->islem_turu];
        } else {
            return self::$islem_turleri[$this->islem_turu];
        }
    }
}
