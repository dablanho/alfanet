<?php

use App\Http\Helpers\DBHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSozlesmelerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!DBHelper::testSchema("public")) {
            Schema::create('sozlesmeler', function (Blueprint $table) {
                $table->id();
                $table->integer("ogr_id");
                $table->double("tutar");
                $table->date("baslangic_tarihi");
                $table->date("bitis_tarihi");
                $table->integer("para_birimi");
                $table->integer("fiyatlandirma_turu");
                $table->integer("vergi_grubu")->default(0);
                $table->string("sozlesme_baslik")->nullable();
                $table->text("aciklama")->nullable();
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
        Schema::dropIfExists('sozlesmeler');
    }
}
