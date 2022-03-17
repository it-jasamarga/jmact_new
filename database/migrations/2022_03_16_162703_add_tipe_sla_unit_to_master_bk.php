<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTipeSlaUnitToMasterBk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('master_bk', function (Blueprint $table) {
            $table->string('tipe_layanan_keluhan', 225)->nullable()->after('keluhan');
            $table->unsignedBigInteger('unit_id')->after('tipe_layanan_keluhan')->nullable();
            $table->foreign('unit_id')->references('id')->on('master_unit')->onDelete('cascade');
            $table->bigInteger('sla')->nullable()->after('unit_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('master_bk', function (Blueprint $table) {
            $table->dropColumn(['tipe_layanan_keluhan']);
            $table->dropColumn(['sla']);
            $table->dropForeign(['unit_id']);
            $table->dropColumn(['unit_id']);
        });
    }
}
