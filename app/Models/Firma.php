<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Firma extends Model
{
    protected $table = "public.firmalar";
    protected $guarded = [];
    public function getSchemaName()
    {
        return trim($this->firmasema);
    }
    public function getDurum(){
        return $this->durum ? "aktif" : "pasif";
    }
    public function getCount(){
        return $this->where("durum",1)->get()->count();
    }
    public function getAd(){
        return $this->ad;
    }
    public function getTelefon(){
        return $this->telefon;
    }
    public function getAdres(){
        return $this->adres;
    }
    public function getIlIlce(){
        $il = $this->belongsTo(Il::class, 'il')->select(['id','ad'])->first();
        $ilce = $this->belongsTo(Ilce::class, 'ilce')->select(['id','ad'])->first();
        return $il["ad"].'/'.$ilce["ad"];
    }
    public function getMail(){
        return $this->mail;
    }
    public function getVergiNo(){
        return $this->vergi_no;
    }
    public function getVergiDairesi(){
        return $this->vergi_daire;
    }
}
