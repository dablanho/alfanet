<?php

use App\Http\Helpers\DBHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasimaPersonellerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!DBHelper::testSchema("public")) {
            Schema::create('tasima_personeller', function (Blueprint $table) {
                $table->id();
                $table->string("ad");
                $table->string("soyad");
                $table->string("kan_grubu")->nullable();
                $table->string("tc")->nullable();
                $table->text("adres")->nullable();
                $table->date("dogum_tarihi")->nullable();
                $table->integer("guzergah_id")->nullable();
                $table->string("enlem")->nullable();
                $table->string("boylam")->nullable();
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
        Schema::dropIfExists('tasima_personeller');
    }
}
