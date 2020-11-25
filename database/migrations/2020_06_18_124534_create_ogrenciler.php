<?php

use App\Http\Helpers\DBHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOgrenciler extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!DBHelper::testSchema("public")) {
            Schema::create('ogrenciler', function (Blueprint $table) {
                $table->id();
                $table->string("ad");
                $table->integer("okul");
                $table->integer("country_id")->nullable();
                $table->integer("city_id")->nullable();
                $table->integer("citydistrict_id")->nullable();
                $table->string("telefon")->nullable();
                $table->json("veliler")->nullable();
                $table->integer("durum")->default(1);
                $table->integer("gosterim")->default(1);
                $table->double("boylam")->nullable();
                $table->double("enlem")->nullable();
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
        Schema::dropIfExists('ogrenciler');
    }
}
