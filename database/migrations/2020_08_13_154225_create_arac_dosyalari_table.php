<?php

use App\Http\Helpers\DBHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAracDosyalariTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!DBHelper::testSchema("public")) {

            Schema::create('arac_dosyalari', function (Blueprint $table) {
                $table->id();
                $table->string("ad")->nullable();
                $table->text("url");
                $table->integer("arac_id");
                $table->integer("durum")->default(1);
                $table->integer("gosterim")->default(1);
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
        if (!DBHelper::testSchema("public")) {
            Schema::dropIfExists('arac_dosyalari');
        }

    }
}
