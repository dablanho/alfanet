<?php

use App\Http\Helpers\DBHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFirmalar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (DBHelper::testSchema("public")) {
            Schema::create('firmalar', function (Blueprint $table) {
                $table->id();
                $table->string('ad');
                $table->integer('ulke');
                $table->string('telefon');
                $table->string('mail');
                $table->string("firmasema");
                $table->string('adres')->nullable();
                $table->string('vergi_no')->nullable();
                $table->string('vergi_daire')->nullable();
                $table->integer('il')->nullable();
                $table->integer('ilce')->nullable();
                $table->string('efatura_username')->nullable();
                $table->string('efatura_passw')->nullable();
                $table->string('sms_firma')->nullable();
                $table->string('sms_kullanici')->nullable();
                $table->string('sms_sifre')->nullable();
                $table->string('sms_baslik')->nullable();
                $table->integer("para_birimi")->nullable();
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
        Schema::dropIfExists('firmalar');
    }
}
