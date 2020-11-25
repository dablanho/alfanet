<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hostes extends Model
{
    protected $table = "hostesler";
    protected $guarded = [];

    public function getBilgiler()
    {
        return [
            "id" => $this->id,
            "tc" => $this->tc,
            "dogum_yeri" => $this->dogum_yeri,
            "dogum_tarihi" => date("d.m.Y", strtotime($this->dogum_tarihi)),
            "dogum_tarihi_org" => $this->dogum_tarihi,
            "name" => $this->ad,
            "okul" => $this->getOkul()->ad ?? "-",
            "okul_obj" => [
                "id" => $this->getOkul()->id ?? "-",
                "ad" => $this->getOkul()->ad ?? "-"
            ],
            "telefon" => $this->telefon,
            "medeni_hali" => $this->medeni_hali,
            "ogr_durum" => $this->ogr_durum,
            "servis" => $this->getServis()->plaka ?? "-",
            "servis_obj" =>  [
                "id" => $this->getServis()->id ?? "-",
                "name" => $this->getServis()->plaka ?? "-",
            ],
            "maas" => $this->maas,
            "adres" => $this->adres,
            "maas_generic" => $this->getMaas(),
            "para_birimi" => $this->para_birimi
        ];
    }
    public function getListBilgiler(){
        return [
            "id" => $this->id,
            "ad" => $this->ad,
            "tel" => $this->telefon,
            "okul" => $this->getOkul()->ad ?? "-",
        ];
    }
    public function getSelect()
    {
        return [
            "id" => $this->id,
            "name" => $this->ad,
        ];
    }
    public function getServis()
    {
        return $this->belongsTo(Arac::class, "servis")->first();
    }
    public function getOkul()
    {
        return $this->belongsTo(Okul::class, "okul")->first();
    }

    public function paraBirim()
    {
        return $this->belongsTo(ParaBirim::class, 'para_birimi');
    }

    public function paraBirimGeneric()
    {
        if (!empty($this->paraBirim))
            return $this->paraBirim->kod;
        return "-";
    }

    public function maasGeneric()
    {
        if ($this->paraBirimGeneric() != '-')
            return $this->maas . " " . $this->paraBirimGeneric();
        return "-";
    }

    public function getMaas()
    {
        if ($this->maasGeneric() != '-')
            return $this->maasGeneric();
        return $this->maas;
    }

    public function getAd() {
        if(!empty($this->ad))
            return $this->ad;
        return "-";
    }
    public function getSearchAd() {
        return $this->getAd()." (Hostes)";
    }

    public function getSearchUrl() {
        return "/hostesler/detay/".$this->id;
    }
}
