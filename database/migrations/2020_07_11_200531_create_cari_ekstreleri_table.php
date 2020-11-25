<?php

use App\Http\Helpers\DBHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCariEkstreleriTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!DBHelper::testSchema("public")) {
            Schema::create('cari_ekstreleri', function (Blueprint $table) {
                $table->id();
                $table->integer("cari_id");
                $table->integer("islem_turu");
                $table->integer("islem_id");
                $table->integer("para_birimi");
                $table->double("islem_tutar");
                $table->integer("is_deleted")->default(0);
                $table->integer("hareket_turu")->default(1);
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
        Schema::dropIfExists('cari_ekstreleri');
    }
}
