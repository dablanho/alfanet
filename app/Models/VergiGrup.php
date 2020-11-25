<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VergiGrup extends Model
{
    protected $table = "vergi_gruplari";

    public function getSelect()
    {
        return [
            "id" => $this->id,
            "ad" => $this->ad . "(%" . $this->oran . ")"
        ];
    }
}
