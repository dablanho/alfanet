<?php

use App\Http\Helpers\DBHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTekliflerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!DBHelper::testSchema("public")) {
            Schema::create('teklifler', function (Blueprint $table) {
                $table->id();
                $table->integer("cari_id");
                $table->integer("teklif_veren");
                $table->double("teklif_tutari");
                $table->date("teklif_tarihi");
                $table->date("teklif_baslangic_tarihi");
                $table->date("teklif_bitis_tarihi");
                $table->string("aciklama")->nullable();
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
        Schema::dropIfExists('teklifler');
    }
}
