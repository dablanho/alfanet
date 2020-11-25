<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CariGrup extends Model
{
    protected $table = "cari_gruplari";
    protected $guarded = [];
    public function getSelect()
    {
        return [
            "id" => $this->id,
            "name" => $this->ad,
        ];
    }
}
