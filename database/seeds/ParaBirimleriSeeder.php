<?php

use App\Models\ParaBirim;
use Illuminate\Database\Seeder;

class ParaBirimleriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ParaBirim::create(
            [
                "ad" => "Türk Lirası",
                "kod" => "TL",
            ]
        );
        /*ParaBirim::create(
            [
                "ad" => "Amerikan Doları",
                "kod" => "USD",
            ]
        );
        ParaBirim::create(
            [
                "ad" => "EURO",
                "kod" => "EUR",
            ]
        );*/
    }
}
