<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GlobalController;
use App\Models\ParaBirim;
use Illuminate\Http\Request;


class ParaBirimController extends GlobalController
{
    public function getParaBirimleri(){
        return $this->resSuccess(ParaBirim::get());
    }

}
