<?php

use App\Http\Helpers\DBHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAracOkullarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!DBHelper::testSchema("public")) {
            Schema::create('arac_okullar', function (Blueprint $table) {
                $table->id();
                $table->integer("okul_id");
                $table->integer("servis_id");
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
        Schema::dropIfExists('arac_okullar');
    }
}
