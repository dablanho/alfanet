<?php

use App\Http\Helpers\DBHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        if (DBHelper::testSchema("public")){

            Schema::create('geozone_cities', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->bigInteger('country_id')->unsigned();
                $table->foreign('country_id')->references('id')->on('geozone_countries')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        if (DBHelper::testSchema("public")){

            Schema::dropIfExists('cities');
        }
    }
}
