<?php

use App\Http\Helpers\DBHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTekliflerV1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!DBHelper::testSchema("public")) {
            if(!Schema::hasColumn('teklifler', 'para_birimi')) {
                Schema::table('teklifler', function (Blueprint $table) {
                    $table->integer('para_birimi')->default(1);
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
