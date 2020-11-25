<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AracOkul extends Model
{
    protected $table = "arac_okullar";
    protected $guarded = [];

    public function arac(){
        return $this->belongsTo(Arac::class,"servis_id");
    }
    
    public function okul(){
        return $this->belongsTo(Okul::class,"okul_id");
    }
}
