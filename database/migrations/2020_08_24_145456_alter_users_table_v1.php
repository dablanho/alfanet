<?php

use App\Http\Helpers\DBHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUsersTableV1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        if (DBHelper::testSchema("public")) {
            if(!Schema::hasColumn('users', 'email_is_verified')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->integer('email_is_verified')->default(1);
                });
            }
            if(!Schema::hasColumn('users', 'email_verification_token')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->string('email_verification_token')->nullable();
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
