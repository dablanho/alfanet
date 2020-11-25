<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TasimaPersonel extends Model
{
    protected $table = "tasima_personeller";
    protected $guarded = [];
    public function getSelect()
    {
        return [
            "id" => $this->id,
            "ad" => $this->ad . " " . $this->soyad,
        ];
    }
    public function guzergah()
    {
        return $this->belongsTo(TeklifGuzergah::class, "guzergah_id");
    }
}
