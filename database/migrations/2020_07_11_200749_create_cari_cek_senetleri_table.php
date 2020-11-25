<?php

use App\Http\Helpers\DBHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCariCekSenetleriTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!DBHelper::testSchema("public")) {
            Schema::create('cari_cek_senetleri', function (Blueprint $table) {
                $table->id();
                $table->integer("cari_id");
                $table->integer("para_birimi");
                $table->string("islem_aciklama");
                $table->integer("tur");
                $table->date("baslangic_tarihi");
                $table->date("vade_tarihi");
                $table->date("islem_tarihi")->nullable();
                $table->double("tutar")->default(0);
                $table->integer("ciro_durum")->default(0);
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
        Schema::dropIfExists('cari_cek_senetleri');
    }
}
