<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Makbuz extends Model
{
    protected $table = "makbuzlar";
    protected $guarded = [];

    public function getListBilgiler($data = 0)
    {
        if ($data == 0)
            return [
                "id" => $this->id,
                "personel" => $this->personel->ad,
                "hesap" => $this->personel->hesap_ad,
                "mesaj" => $this->mesaj,
                "aciklama" => $this->aciklama,
                "tutar" => $this->tutar . " " . $this->paraBirimi->kod,
            ];
        else
            return [
                "id" => $this->id,
                "ogrenci" => $this->ogrenci->ad,
                "personel" => $this->personel->ad,
                "hesap" => $this->personel->hesap_ad,
                "mesaj" => $this->mesaj,
                "aciklama" => $this->aciklama,
                "tutar" => $this->tutar . " " . $this->paraBirimi->kod,
            ];
    }
    public function hesap()
    {
        return $this->belongsTo(Hesap::class, "hesap");
    }
    public function personel()
    {
        return $this->belongsTo(Personel::class, "alan_personel");
    }
    public function paraBirimi()
    {
        return $this->belongsTo(ParaBirim::class, "para_birimi");
    }
    public function ogrenci()
    {
        return $this->belongsTo(Ogrenciler::class, "ogr_id");
    }
}
