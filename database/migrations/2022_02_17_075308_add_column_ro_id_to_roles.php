<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnRoIdToRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->unsignedBigInteger('ro_id')->after('name_alias')->nullable();
        });
        Schema::table('roles', function (Blueprint $table) {
            $table->foreign('ro_id')->references('id')->on('master_ro')->onDelete('cascade');
        });
        Schema::table('roles', function (Blueprint $table) {
            $table->foreign('regional_id')->references('id')->on('master_regional')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->dropForeign(['regional_id']);
            $table->dropForeign(['ro_id']);
            $table->dropColumn(['ro_id']);
        });
    }
}
