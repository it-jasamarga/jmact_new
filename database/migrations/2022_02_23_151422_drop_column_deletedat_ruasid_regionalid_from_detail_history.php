<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropColumnDeletedatRuasidRegionalidFromDetailHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detail_history', function (Blueprint $table) {
            $table->dropForeign(['regional_id']);
            $table->dropForeign(['ruas_id']);
            $table->dropColumn(['regional_id']);
            $table->dropColumn(['ruas_id']);
            $table->dropColumn(['deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detail_history', function (Blueprint $table) {
            $table->unsignedBigInteger('regional_id')->nullable();
            $table->foreign('regional_id')->references('id')->on('master_regional')->onDelete('cascade');
            $table->unsignedBigInteger('ruas_id')->nullable();
            $table->foreign('ruas_id')->references('id')->on('master_ruas')->onDelete('cascade');
            $table->softDeletes();
        });
    }
}
