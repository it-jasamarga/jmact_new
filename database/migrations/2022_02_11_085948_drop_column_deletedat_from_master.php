<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropColumnDeletedatFromMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('master_bk', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });
        Schema::table('master_golken', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });
        Schema::table('master_jenis_claim', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });
        Schema::table('master_regional', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });
        Schema::table('master_ro', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });
        Schema::table('master_ruas', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });
        Schema::table('master_status', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });
        Schema::table('master_sumber', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });
        Schema::table('master_unit', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('master', function (Blueprint $table) {
            //
        });
    }
}
