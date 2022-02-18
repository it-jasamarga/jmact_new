<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterSumberidToClaim extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('claim', function (Blueprint $table) {
            $table->unsignedBigInteger('sumber_id')->after('jenis_claim_id')->nullable();
        });
        Schema::table('claim', function (Blueprint $table) {
            $table->foreign('sumber_id')->references('id')->on('master_sumber')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('claim', function (Blueprint $table) {
            $table->dropColumn(['sumber_id']);
        });
    }
}
