<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sozlesme extends Model
{
    protected $table = "sozlesmeler";

    public function getBilgiler()
    {
        return [
            "sozlesme" => $this,
            "ogrenci" => $this->belongsTo(Ogrenciler::class, "ogr_id")->first()->getBilgiler(),
            "para_birimi" => $this->belongsTo(ParaBirim::class, "para_birimi")->first(),
            "fiyatlandirma_turu" => $this->belongsTo(FiyatlandirmaTuru::class, "fiyatlandirma_turu")->first() ?? ["ad" => "Normal" , "oran" => 0],
            "vergi_grubu" => $this->belongsTo(VergiGrup::class, "vergi_grubu")->first(),
            "odemeler" => Odeme::getBilgiler($this->id),
            "toplam" => round($this->getToplamTutar()->sum,2),
            "odenen" => round($this->getToplamOdenen()->sum,2),
            "kalan" => round($this->getToplamKalan()->sum,2),
        ];
    }

    public function getListBilgiler()
    {
        return [
            "id" => $this->id,
            "baslik" => $this->sozlesme_baslik,
            "baslangic" => $this->baslangic_tarihi,
            "bitis" => $this->bitis_tarihi,
            "okul" => $this->ogrenci->getOkul()->ad ?? "-",
            "tutar_kdv_dahil" => $this->tutar." ".$this->paraBirimi->kod
        ];
    }

    public function paraBirimi() {
        return $this->belongsTo(ParaBirim::class, "para_birimi");
    }

    public function ogrenci() {
        return $this->belongsTo(Ogrenciler::class, "ogr_id");
    }

    public function getToplamTutar(){
        return $this->hasMany(Odeme::class,"sozlesme_id")->select(DB::raw('SUM(tutar)'))->first();
    }
    public function getToplamOdenen(){
        return $this->hasMany(Odeme::class,"sozlesme_id")->select(DB::raw('SUM(odenen)'))->first();
    }
    public function getToplamKalan(){
        return $this->hasMany(Odeme::class,"sozlesme_id")->select(DB::raw('SUM(kalan)'))->first();
    }
}
