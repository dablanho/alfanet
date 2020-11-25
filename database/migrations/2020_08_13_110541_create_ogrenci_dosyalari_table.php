<?php

use App\Http\Helpers\DBHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOgrenciDosyalariTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!DBHelper::testSchema("public")) {
            Schema::create('ogrenci_dosyalari', function (Blueprint $table) {
                $table->id();
                $table->string("ad");
                $table->text("url");
                $table->integer("ogrenci_id");
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
        if (!DBHelper::testSchema("public")) {
            Schema::dropIfExists('ogrenci_dosyalari');
        }

    }
}
