<?php

use App\Http\Controllers\Excel;
use App\Models\Markalar;
use App\Models\Modeller;
use Illuminate\Database\Seeder;

class MarkaModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        if ($xlsx = Excel::parse(public_path('arac-veritabani.xlsx'))) {
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
