<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OgrenciDosya extends Model
{
    //
    protected $table = "ogrenci_dosyalari";
    protected $guarded = [];

    public function ogrenciAd() {
        return Ogrenciler::find($this->ogrenci_id)->ad;
    }
}
