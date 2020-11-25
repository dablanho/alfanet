<?php

use App\Http\Helpers\DBHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoforler extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!DBHelper::testSchema("public")){
            Schema::create('soforler', function (Blueprint $table) {
                $table->id();
                $table->string("ad");
                $table->double("maas")->nullable();
                $table->string("tc")->nullable();
                $table->date("dogum_tarihi")->nullable();
                $table->string("dogum_yeri")->nullable();
                $table->string("adres")->nullable();
                $table->string("ev_tel")->nullable();
                $table->string("cep_tel")->nullable();
                $table->string("banka_sube")->nullable();
                $table->string("banka_ad")->nullable();
                $table->string("hesap_no")->nullable();
                $table->string("ehliyet_no")->nullable();
                $table->string("ehliyet_sinif")->nullable();
                $table->string("seyahat_saglam_sigorta")->nullable();
                $table->date("seyahat_saglam_sigorta_tarih")->nullable();
                $table->string("beynelmilel_ehliyet")->nullable();
                $table->date("beynelmilel_ehliyet_tarih")->nullable();
                $table->string("src_belgesi")->nullable();
                $table->date("src_belgesi_tarih")->nullable();
                $table->string("pasaport_no")->nullable();
                $table->date("pasaport_no_tarih")->nullable();
                $table->string("psiko_teknik_no")->nullable();
                $table->date("psiko_teknik_no_tarih")->nullable();
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
        Schema::dropIfExists('soforler');
    }
}
