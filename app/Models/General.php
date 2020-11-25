<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class General extends Model
{
    public function formatDate($date)
    {
        return date("d.m.Y", strtotime($date));
    }
    public function formatDateTime($time)
    {
        return date("d.m.Y H:i", strtotime($time));
    }
}
