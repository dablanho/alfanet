<?php

use App\Http\Helpers\DBHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMakbuzlarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!DBHelper::testSchema("public")) {
            Schema::create('makbuzlar', function (Blueprint $table) {
                $table->id();
                $table->double("tutar");
                $table->integer("para_birimi");
                $table->integer("hesap");
                $table->date("odeme_tarihi");
                $table->integer("alan_personel");
                $table->text("mesaj")->nullable();
                $table->text("aciklama")->nullable();
                $table->integer("sms_gonderildi")->default(0);
                $table->string("telefon")->nullable();
                $table->integer("sozlesme_id")->nullable();
                $table->integer("ogr_id")->nullable();
                $table->text("odeme_yapan")->nullable();
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
        Schema::dropIfExists('makbuzlar');
    }
}
