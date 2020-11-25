<?php

use App\Http\Helpers\DBHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTekliflerV2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!DBHelper::testSchema("public")) {
            if (!Schema::hasColumn('teklifler', 'kabul_tarihi')) {
                Schema::table('teklifler', function (Blueprint $table) {
                    $table->date('kabul_tarihi')->nullable();
                    $table->string("iptal_aciklama")->nullable();
                    $table->integer("kdv_durum")->nullable(); //0 hariç 1 dahil
                    $table->double("kdv_haric_tutar")->nullable();
                    $table->double("kdv_tutar")->nullable();
                });
            }
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
