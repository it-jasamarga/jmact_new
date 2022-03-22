<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUnitIdToMasterJenisClaim extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('master_jenis_claim', function (Blueprint $table) {
            $table->unsignedBigInteger('unit_id')->after('jenis_claim')->nullable();
            $table->foreign('unit_id')->references('id')->on('master_unit')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('master_jenis_claim', function (Blueprint $table) {
            $table->dropForeign(['unit_id']);
        });
    }
}
