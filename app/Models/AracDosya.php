<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AracDosya extends Model
{
    //
    protected $table = "arac_dosyalari";
    protected $guarded = [];

    public function getArac() {
        return Arac::select(['id', 'plaka'])->find($this->arac_id);
    }
}
