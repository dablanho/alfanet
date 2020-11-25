<?php

use App\Http\Helpers\DBHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeklifGuzergahlarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!DBHelper::testSchema("public")) {
            Schema::create('teklif_guzergahlar', function (Blueprint $table) {
                $table->id();
                $table->string("ad");
                $table->integer("personel_sayisi")->nullable();
                $table->integer("kilometre")->nullable();
                $table->integer("arac_sayisi");
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
        Schema::dropIfExists('teklif_guzergahlar');
    }
}
