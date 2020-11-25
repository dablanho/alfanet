<?php

use App\Http\Helpers\DBHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHesaplarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!DBHelper::testSchema("public")) {
            Schema::create('hesaplar', function (Blueprint $table) {
                $table->id();
                $table->string("hesap_ad");
                $table->string("banka_ad");
                $table->string("iban_no")->nullable();
                $table->integer("para_birimi");
                $table->double("bakiye")->default(0);
                $table->double("baslangic_bakiye")->default(0);
                $table->integer('durum')->default(1);
                $table->integer('gosterim')->default(1);
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
        Schema::dropIfExists('hesaplar');
    }
}
