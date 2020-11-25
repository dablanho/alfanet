<?php

use App\Http\Helpers\DBHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOdemelerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!DBHelper::testSchema("public")) {
            Schema::create('odemeler', function (Blueprint $table) {
                $table->id();
                $table->integer("ogr_id");
                $table->integer("sozlesme_id");
                $table->date("odeme_tarihi");
                $table->double("kalan");
                $table->double("tutar");
                $table->integer("para_birimi");
                $table->double("odenen")->default(0);
                $table->integer("okul_id")->default(0);
                $table->integer("servis_id")->default(0);
                $table->integer("fatura_id")->default(0);
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
        Schema::dropIfExists('odemeler');
    }
}
