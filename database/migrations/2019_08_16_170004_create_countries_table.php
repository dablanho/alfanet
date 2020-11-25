<?php

use App\Http\Helpers\DBHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        if (DBHelper::testSchema("public")){

            Schema::create('geozone_countries', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('iso_code', 2)->unique();
                $table->string('name');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        if (DBHelper::testSchema("public")){

            Schema::dropIfExists('countries');
        }
    }
}
