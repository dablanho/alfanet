<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Excel;
use App\Models\Firma;
use App\Models\Markalar;
use App\Models\Modeller;
use Illuminate\Http\Request;

class AddMarkaModelController extends Controller
{
    public static function ekle()
    {
        if ($xlsx = Excel::parse('arac-veritabani.xlsx')) {
            foreach ($xlsx->rows() as $data) {
                if (Markalar::where("marka_kodu", $data[0])->count() == 0) {
                    Markalar::insert(["marka_kodu" => $data[0], "marka_adi" => $data[1]]);
                }
                Modeller::insert(["marka_kodu" => $data[0], "model_adi" => $data[2]]);
            }
        }
        return response()->json(['msg'=>'success'],200);
    }
}
