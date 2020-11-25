<?php

namespace App\Http\Controllers;

use App\Models\Hesap;
use App\Models\HesapHareket;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GlobalController extends Controller
{


    public function resSuccess($data, $message = "Başarılı", $status = 200)
    {
        $response = [
            "data" => $data,
            "message" => $message,
            "status" => "Success",
        ];
        return response()->json($response, $status);
    }
    public function resError($data, $message = "İşlem Sırasında Hata Oluştu", $status = 422)
    {
        $response = [
            "data" => $data,
            "message" => $message,
            "status" => "Error",
        ];
        return response()->json($response, $status);
    }
    //islem türü 1 => ödeme yapma (-) // islem türü 2 => ödeme alma (+)
    public function hesapIslemiYap($hesap_id, $islem_tutar, $para_birimi, $islem_turu = 1, $cari_id = 0, $fatura_id = 0)
    {
        HesapHareket::create([
            "hesap_id" => $hesap_id,
            "islem_tutari" => $islem_tutar,
            "para_birimi" => $para_birimi,
            "islem_turu" => $islem_turu,
            "cari_id" =>  $cari_id,
            "fatura_id" => $fatura_id,
        ]);
        $hesap = Hesap::where("id", $hesap_id);
        if ($islem_turu == 1) $hesap->update(["bakiye" => $hesap->first()->bakiye - $islem_tutar]);
        else $hesap->update(["bakiye" => $hesap->first()->bakiye + $islem_tutar]);
    }
    public function get2YilaKadarTarihler()
    {
        return [
            ["deger" => date("Y-m-d") . "/" . date("Y-m-d"), "baslik" => trans("general.bugun")],
            ["deger" => date("Y-m-d", strtotime(date("Y-m-d") . " -7 day")) . "/" . date("Y-m-d"), "baslik" => trans("general.son-yedi-gun")],
            ["deger" => date("Y-m-d", strtotime(date("Y-m-d") . " -1 month")) . "/" . date("Y-m-d"), "baslik" => trans("general.son-bir-ay")],
            ["deger" => date("Y-m-d", strtotime(date("Y-m-d") . " -1 year")) . "/" . date("Y-m-d"), "baslik" => trans("general.son-bir-yil")],
            ["deger" => date("Y-m-d", strtotime(date("Y-m-d") . " -2 year")) . "/" . date("Y-m-d"), "baslik" => trans("general.son-iki-yil")],
        ];
    }

    public function addFile($image, $rootPath, $fileName)
    {
        if(empty($fileName)) {
            $file_name = Str::random(15) . Str::slug($image->getClientOriginalName()) . "." . $image->getClientOriginalExtension();
        } else {
            $file_name = Str::random(15) . Str::slug($fileName) . "." . $image->getClientOriginalExtension();
        }
        $image->move(public_path() . $rootPath, $file_name);
        return $rootPath . $file_name;
    }

}
