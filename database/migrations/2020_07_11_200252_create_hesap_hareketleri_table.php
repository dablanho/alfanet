<?php

use App\Http\Helpers\DBHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHesapHareketleriTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!DBHelper::testSchema("public")) {
            Schema::create('hesap_hareketleri', function (Blueprint $table) {
                $table->id();
                $table->double("islem_tutari");
                $table->integer("islem_turu");
                $table->integer("hesap_id");
                $table->integer("para_birimi");
                $table->integer("cari_id")->default(0);
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
        Schema::dropIfExists('hesap_hareketleri');
    }
}
