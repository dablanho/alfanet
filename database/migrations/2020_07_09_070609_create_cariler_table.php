<?php

use App\Http\Helpers\DBHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarilerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!DBHelper::testSchema("public")) {
            Schema::create('cariler', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('ad');
                $table->integer('cari_grup_id');
                $table->string('adres')->nullable();
                $table->json('ogrenciler')->nullable();
                $table->string('vergi_no')->nullable();
                $table->string('vergi_daire')->nullable();
                $table->integer('telefon')->nullable();
                $table->string('mail')->nullable();
                $table->string('web_adresi')->nullable();
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
        Schema::dropIfExists('cariler');
    }
}
