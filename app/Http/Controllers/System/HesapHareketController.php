<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GlobalController;
use App\Models\HesapHareket;
use Illuminate\Http\Request;

class HesapHareketController extends GlobalController
{
    //

    public function indexByHesapID($hesap_id){
        $datas = [];
        foreach (HesapHareket::where(['durum' => 1, 'hesap_id' => $hesap_id])->orderBy('created_at', 'desc')->get() as $key=>$val) {
            $datas[] = $val->getInfos();
        }
        return $this->resSuccess($datas);
    }
}
