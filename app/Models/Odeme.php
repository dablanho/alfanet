<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Odeme extends Model
{
    protected $table = "odemeler";

    public static function getBilgiler($id = 0)
    {
        $odeme = new Odeme();
        if ($id > 0) {
            $odeme = $odeme->where("sozlesme_id", $id)->orderBy("odeme_tarihi","asc");
        }
        $goTo = [];
        foreach ($odeme->get() as $data) {
            $paraBirimi = $data->belongsTo(ParaBirim::class, "para_birimi")->first()->kod;
            $goTo[] = [
                "id" => $data->id,
                "kalan" => $data->kalan . $paraBirimi,
                "odenen" => $data->odenen. $paraBirimi,
                "tutar" => $data->tutar. $paraBirimi,
                "okul" => $data->belongsTo(Okul::class, "okul_id")->first()->ad ?? "-",
                "servis" => $data->belongsTo(Arac::class, "servis_id")->first()->plaka ?? 0,
                "tarih" => date("d.m.Y", strtotime($data->odeme_tarihi)),
                "ay" => date("m", strtotime($data->odeme_tarihi)),
            ];
        }
        return $goTo;
    }

    public function getParaBirimi() {
        return $this->belongsTo(ParaBirim::class, "para_birimi")->first()->kod;
    }
    public function paraBirimi() {
        return $this->belongsTo(ParaBirim::class, "para_birimi");
    }
    public function ogrenci() {
        return $this->belongsTo(Ogrenciler::class, "ogr_id");
    }
    public function servis() {
        return $this->belongsTo(Arac::class, "servis_id");
    }
    public function okul() {
        return $this->belongsTo(Okul::class, "okul_id");
    }
}
