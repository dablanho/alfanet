<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teklif extends Model
{
    protected $table = "teklifler";
    protected $guarded = [];

    public function guzergahlar()
    {
        return $this->hasMany(TeklifGuzergah::class, "teklif_id");
    }
    public function cari()
    {
        return $this->belongsTo(Cari::class, "cari_id");
    }
    public function personel()
    {
        return $this->belongsTo(Personel::class, "teklif_veren");
    }
    public function paraBirimi()
    {
        return $this->belongsTo(ParaBirim::class, "para_birimi");
    }
    public function personeller()
    {
        $goTo = [];
        foreach ($this->guzergahlar()->get() as $guzergah) {
            foreach (TasimaPersonel::where("guzergah_id", $guzergah->id)->with("guzergah")->get() as $personel) {
                $goTo[] = $personel;
            }
        }
        return $goTo;
    }
    
}
