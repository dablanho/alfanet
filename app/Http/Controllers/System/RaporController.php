<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GlobalController;
use App\Models\Odeme;
use App\Models\Okul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RaporController extends GlobalController
{
    public function kalanOdemeler($where = [])
    {
        $arr = [];
        foreach (Odeme::select(['para_birimi'])->groupBy('para_birimi')->get() as $val) {
            foreach (Odeme::where(['durum' => 1, "para_birimi" => $val->para_birimi])
                ->where("kalan", ">", "0")
                ->whereBetween('odeme_tarihi', array(date('Y-m-01'), date('Y-m-t')))
                ->get() as $odeme) {
                $arr[] = [
                    "id" => $odeme->sozlesme_id ?? "Belirsiz",
                    "ogrenci" => $odeme->ogrenci->ad ?? "Belirsiz",
                    "okul" => $odeme->okul->ad ?? "Belirsiz",
                    "okul_id" => $odeme->okul->id ?? "Belirsiz",
                    "servis" => $odeme->servis->plaka ?? "Belirsiz",
                    "servis_id" => $odeme->servis->id ?? "Belirsiz",
                    "kalan" => $odeme->kalan . " " . $odeme->paraBirimi->kod,
                    "tutar" => $odeme->tutar . " " . $odeme->paraBirimi->kod,
                ];
            }
        }
        return $this->resSuccess($arr);
    }

    public function okulCirolari($where = [])
    {
        $okullar = Okul::where(["durum" => 1, "gosterim" => 1])->get();
        $goTo = [];
        $aylar = [];
        $aylar["okul"] =   [
            "key" => "okul",
            "sortable" => "true",
            "label" => "Okul Adı",
        ];
        foreach ($okullar as $okul) {
            $goTo[$okul->id] = [
                "id" => $okul->id,
                "okul" => $okul->ad,
            ];
            foreach (Odeme::where("okul_id", $okul->id)->orderBy("odeme_tarihi", "asc")->where("odeme_tarihi", ">=", date("Y-01-01"))->get() as $odeme) {
                $aylar[date("Y-m", strtotime($odeme->odeme_tarihi))] =
                    [
                        "label" => date('Y', strtotime($odeme->odeme_tarihi)) . " " . trans("months." . date("m", strtotime($odeme->odeme_tarihi))), //trans("months." . date("m", strtotime($odeme->odeme_tarihi))),
                        "key" => date("Y-m", strtotime($odeme->odeme_tarihi)),
                        "sortable" => "true",
                    ];
                $goTo[$okul->id][date("Y-m", strtotime($odeme->odeme_tarihi))] = round(Odeme::where("okul_id", $okul->id)
                    ->whereBetween("odeme_tarihi", [date("Y-m-01", strtotime($odeme->odeme_tarihi)), date("Y-m-t", strtotime($odeme->odeme_tarihi))])
                    ->select(DB::raw("sum(tutar)"))->first()->sum, 2) . " TL";
            }
        }

        return $this->resSuccess(["body" => array_values($goTo), "head" => array_values($aylar)]);
    }
    public function okulToplamOdenen($where = [])
    {
        $okullar = Okul::where(["durum" => 1, "gosterim" => 1])->get();
        $goTo = [];
        $aylar = [];
        $aylar["okul"] =   [
            "key" => "okul",
            "sortable" => "true",
            "label" => "Okul Adı",
        ];
        foreach ($okullar as $okul) {
            $goTo[$okul->id] = [
                "id" => $okul->id,
                "okul" => $okul->ad,
            ];
            foreach (Odeme::where("okul_id", $okul->id)->orderBy("odeme_tarihi", "asc")->where("odeme_tarihi", ">=", date("Y-01-01"))->get() as $odeme) {
                $aylar[date("Y-m", strtotime($odeme->odeme_tarihi))] =
                    [
                        "label" => date('Y', strtotime($odeme->odeme_tarihi)) . " " . trans("months." . date("m", strtotime($odeme->odeme_tarihi))), //trans("months." . date("m", strtotime($odeme->odeme_tarihi))),
                        "key" => date("Y-m", strtotime($odeme->odeme_tarihi)),
                        "sortable" => "true",
                    ];
                $goTo[$okul->id][date("Y-m", strtotime($odeme->odeme_tarihi))] =
                    //Toplam Tutar
                    round(Odeme::where("okul_id", $okul->id)
                        ->whereBetween("odeme_tarihi", [date("Y-m-01", strtotime($odeme->odeme_tarihi)), date("Y-m-t", strtotime($odeme->odeme_tarihi))])
                        ->select(DB::raw("sum(tutar)"))->first()->sum, 2) . " TL / " .
                    //Toplam Ödenen
                    round(Odeme::where("okul_id", $okul->id)
                        ->whereBetween("odeme_tarihi", [date("Y-m-01", strtotime($odeme->odeme_tarihi)), date("Y-m-t", strtotime($odeme->odeme_tarihi))])
                        ->select(DB::raw("sum(odenen)"))->first()->sum, 2) . " TL";
            }
        }

        return $this->resSuccess(["body" => array_values($goTo), "head" => array_values($aylar)]);
    }
}
