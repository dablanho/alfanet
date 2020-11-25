<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FiyatlandirmaTuru extends Model
{
    protected $table = "fiyatlandirma_turleri";
    public function getSelect()
    {
        return [
            "id" => $this->id,
            "ad" => $this->ad . "(%" . $this->oran . ")"
        ];
    }
}
