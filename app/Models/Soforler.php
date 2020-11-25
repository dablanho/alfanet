<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Soforler extends General
{
    protected $table = "soforler";
    protected $guarded = [];

    public function getSelect(){
        return [
            "id" => $this->id,
            "name" => $this->ad,
        ];
    }

    public function paraBirim() {
        return $this->belongsTo(ParaBirim::class, 'para_birimi');
    }

    public function paraBirimGeneric() {
        if(!empty($this->paraBirim))
            return $this->paraBirim->kod;
        return "-";
    }

    public function maasGeneric() {
        if($this->paraBirimGeneric() != '-')
            return $this->maas." ".$this->paraBirimGeneric();
        return "-";
    }

    public function getMaas(){
        if($this->maasGeneric() != '-')
            return $this->maasGeneric();
        return $this->maas;
    }

    public function getSeyahatSigortaTarih() {
        if(!empty($this->seyahat_saglam_sigorta_tarih)) {
            return $this->formatDate($this->seyahat_saglam_sigorta_tarih);
        }
        return "-.-.-";
    }
    public function getBeynelmilelEhliyetTarih() {
        if(!empty($this->beynelmilel_ehliyet_tarih)) {
            return $this->formatDate($this->beynelmilel_ehliyet_tarih);
        }
        return "-.-.-";
    }
    public function getSrcBelgeTarih() {
        if(!empty($this->src_belgesi_tarih)) {
            return $this->formatDate($this->src_belgesi_tarih);
        }
        return "-.-.-";
    }
    public function getPassportTarih() {
        if(!empty($this->pasaport_no_tarih)) {
            return $this->formatDate($this->pasaport_no_tarih);
        }
        return "-.-.-";
    }
    public function getPsikoTeknikTarih() {
        if(!empty($this->psiko_teknik_no_tarih)) {
            return $this->formatDate($this->psiko_teknik_no_tarih);
        }
        return "-.-.-";
    }

    public function getAd() {
        if(!empty($this->ad))
            return $this->ad;
        return "-";
    }
    public function getSearchAd() {
        return $this->getAd()." (Şoför)";
    }

    public function getSearchUrl() {
        return "/soforler/detay/".$this->id;
    }


}
