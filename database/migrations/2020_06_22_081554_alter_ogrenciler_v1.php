<?php

use App\Http\Helpers\DBHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterOgrencilerV1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!DBHelper::testSchema("public")) {
            Schema::table('ogrenciler', function (Blueprint $table) {
                $table->string("tc")->nullable();
                $table->string("dogum_yeri")->nullable();
                $table->string("kan_grubu")->nullable();
                $table->string("fotograf")->nullable();
                $table->string("koltuk_no")->nullable();
                $table->integer("servis_id")->default(0);
                $table->integer("cinsiyet")->nullable();//0 erkek 1 kız
                $table->date("dogum_tarihi")->nullable();
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
        //
    }
}
