<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GlobalController;
use App\Models\Arac;
use App\Models\Hostes;
use App\Models\Ogrenciler;
use App\Models\Okul;
use App\Models\Soforler;
use Illuminate\Http\Request;

class SearchController extends GlobalController
{
    //

    public function combine_searchs(Request $request){
        $students = $this->reformatArray(Ogrenciler::whereRaw('LOWER(ad) LIKE ? or tc LIKE ?', ['%'.strtolower($request->word).'%', '%'.strtolower($request->word).'%'])->get());
        $schools = $this->reformatArray(Okul::whereRaw('LOWER(ad) LIKE ?', ['%'.strtolower($request->word).'%'])->get());
        $vehicles = $this->reformatArray(Arac::whereRaw('LOWER(plaka) LIKE ?', ['%'.strtolower($request->word).'%'])->get());
        $drivers = $this->reformatArray(Soforler::whereRaw('LOWER(ad) LIKE ?', ['%'.strtolower($request->word).'%'])->get());
        $hostess = $this->reformatArray(Hostes::whereRaw('LOWER(ad) LIKE ?', ['%'.strtolower($request->word).'%'])->get());
        return $this->resSuccess(array_merge($students, $schools, $vehicles, $drivers, $hostess));
    }

    function reformatArray($arr) {
        $newArr = [];
        foreach ($arr as $item) {
            $newArr[] = [
                "text" => $item->getSearchAd(),
                "url" => $item->getSearchUrl()
            ];
        }
        return $newArr;
    }
}
