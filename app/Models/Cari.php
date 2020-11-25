<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cari extends Model
{
    protected $table = "cariler";
    protected $guarded = [];

    public function getBilgiler()
    {
        $goTo["cari"] = $this;
        $goTo["ogrenciler"] = [];
        $goTo["cari_grup_obj"] = [
            'id' => $this->belongsTo(CariGrup::class,"cari_grup_id")->first()->id,
            'name' => $this->belongsTo(CariGrup::class,"cari_grup_id")->first()->ad
        ];
        $goTo["grup"] = $this->belongsTo(CariGrup::class,"cari_grup_id")->first()->ad;
        /*foreach (json_decode($this->ogrenciler) as $ogrenciler) {
            $goTo["ogrenciler"][] = Ogrenciler::where("id", $ogrenciler->id)->first()->getBilgiler();
        }*/
        return $goTo;
    }
    public function getSelect()
    {
        return [
            "name" => $this->ad,
            "id" => $this->id
        ];
    }
    public function getCariGrup() {
        return $this->belongsTo(CariGrup::class, "cari_grup_id")->select(['id', 'ad'])->first();
    }
    public function getAd() {
        return $this->ad;
    }
}
