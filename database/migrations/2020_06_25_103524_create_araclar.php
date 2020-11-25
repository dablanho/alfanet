<?php

use App\Http\Helpers\DBHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAraclar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!DBHelper::testSchema("public")) {
            Schema::create('araclar', function (Blueprint $table) {
                $table->id();
                $table->integer("arac_durumu")->default(1); //1 öz mal 2 kira
                $table->integer("sofor_id");
                $table->string("model_yili");
                $table->integer("model_id");
                $table->integer("marka_kodu");
                $table->string("plaka");
                $table->integer("koltuk_sayisi")->nullable();
                $table->string("ruhsat_sahibi")->nullable();
                $table->string("ruhsat_sahibi_telefon")->nullable();
                $table->string("servis_kodu")->nullable();
                $table->string("servis_no")->nullable();
                $table->date("tescil_tarihi")->nullable();
                $table->date("son_muayene_tarihi")->nullable(); // EDIT: muayene gecerlilik tarihi
                $table->string("trafik_sigortasi")->nullable();
                $table->date("trafik_sigortasi_tarihi")->nullable();
                $table->string("koltuk_sigortasi")->nullable();
                $table->date("koltuk_sigortasi_tarihi")->nullable();
                $table->string("kasko")->nullable();
                $table->date("kasko_tarihi")->nullable();
                $table->string("egzoz_pulu_muayene")->nullable();
                $table->date("egzoz_pulu_muayene_tarihi")->nullable();
                $table->integer("durum")->default(1);
                $table->integer("gosterim")->default(1);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('araclar');
    }
}
