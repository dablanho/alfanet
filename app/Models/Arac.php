<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Arac extends General
{
    protected $table = "araclar";
    protected $guarded = [];

    public function getBilgiler()
    {
        try {
            return  [
                "arac" => $this,
                "id" => $this->id,
                "plaka" => $this->plaka,
                "model_yili" => $this->model_yili,
                "model_obj" => [
                    "id" => $this->belongsTo(Modeller::class, "model_id")->first()->id,
                    "model_adi" => $this->belongsTo(Modeller::class, "model_id")->first()->model_adi
                ],
                "marka_obj" => [
                    "id" => $this->belongsTo(Modeller::class, "model_id")->first()->id,
                    "marka_kodu" => $this->belongsTo(Modeller::class, "model_id")->first()->marka_kodu,
                    "marka_adi" => Markalar::where("marka_kodu", $this->marka_kodu)->first()->marka_adi
                ],
                "sofor_obj" => [
                    "id" => $this->belongsTo(Soforler::class, "sofor_id")->first()->id,
                    "name" => $this->belongsTo(Soforler::class, "sofor_id")->first()->ad
                ],
                "model" => $this->belongsTo(Modeller::class, "model_id")->first()->model_adi,
                "sofor" => $this->belongsTo(Soforler::class, "sofor_id")->first()->ad,
                "marka" => Markalar::where("marka_kodu", $this->marka_kodu)->first()->marka_adi,
                "ogrenciler" => $this->ogrenciler()
            ];
        } catch (\Throwable $e) {
            return ["Error"];
        }
    }
    public function getListBilgiler()
    {
        try {
            return  [
                "id" => $this->id,
                "plaka" => $this->plaka,
                "sofor" => $this->belongsTo(Soforler::class, "sofor_id")->first()->ad,
                "marka" => Markalar::where("marka_kodu", $this->marka_kodu)->first()->marka_adi,
                "model_yili" => $this->model_yili,
            ];
        } catch (\Throwable $e) {
            return [];
        }
    }
    public function ogrenciler(){
        return $this->hasMany(Ogrenciler::class,"servis_id")->with("okul")->get();
    }
    public function getSelect()
    {
        return [
            "id" => $this->id,
            "name" => $this->plaka,
        ];
    }

    public function getMarkaAdi() {
        $marka = Markalar::where("marka_kodu", $this->marka_kodu)->first();
        if(!empty($marka)) {
            return $marka->marka_adi;
        }
        return "-";
    }

    public function getModelAdi() {
        $model = Model::where("id", $this->model_id)->first();
        if(!empty($model)) {
            return $model->model_adi;
        }
        return "-";
    }

    public function getSonrakiMuayeneTarih() {
        if(!empty($this->son_muayene_tarihi)) {
            return $this->formatDate($this->son_muayene_tarihi);
        }
        return "-.-.-";
    }

    public function getTrafikSigortaTarih() {
        if(!empty($this->trafik_sigortasi_tarihi)) {
            return $this->formatDate($this->trafik_sigortasi_tarihi);
        }
        return "-.-.-";
    }

    public function getKaskoTarih() {
        if(!empty($this->kasko_tarihi)) {
            return $this->formatDate($this->kasko_tarihi);
        }
        return "-.-.-";
    }

    public function getAd() {
        if(!empty($this->plaka))
            return $this->plaka;
        return "-";
    }
    public function getSearchAd() {
        return $this->getAd()." (Servis)";
    }

    public function getSearchUrl() {
        return "/araclar/detay/".$this->id;
    }

    public function getSoforAdi() {
        $sofor = Soforler::where('id', $this->sofor_id)->first();
        if(!empty($sofor))
            return Soforler::where('id', $this->sofor_id)->first()->ad;
        return '-';
    }
}
