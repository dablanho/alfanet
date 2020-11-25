<?php

use App\Http\Helpers\DBHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHosteslerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!DBHelper::testSchema("public")) {
            Schema::create('hostesler', function (Blueprint $table) {
                $table->id();
                $table->string("ad");
                $table->string("tc")->nullable();
                $table->string("dogum_yeri")->nullable();
                $table->string("medeni_hali")->nullable();
                $table->string("telefon")->nullable();
                $table->string("ogr_durum")->nullable();
                $table->text("adres")->nullable();
                $table->date("dogum_tarihi")->nullable();
                $table->integer("okul")->nullable();
                $table->integer("servis")->nullable();
                $table->double("maas")->default(0);
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
        Schema::dropIfExists('hostesler');
    }
}
