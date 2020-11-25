<?php

use App\Http\Controllers\AddMarkaModelController;
use App\Models\Firma;
use App\Models\User;
use Illuminate\Database\Seeder;

class StarterKit extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $firma = Firma::create([
            "ad" => "Alfalin Yazılım Bilişim LTD. ŞTİ.",
            "ulke" => "1",
            "telefon"=>"0534 036 22 12",
            "mail" => "bilgi@arantu.com",
            "firmasema" => "alfalin"
        ]);
        User::create([
            "name" => "Test User",
            "email" => "test@mail.com",
            "password" => \Hash::make("123456"),
            "firmasema" => $firma->firmasema
        ]);
        \Artisan::call('updateschemas');
        AddMarkaModelController::ekle();
    }
}
