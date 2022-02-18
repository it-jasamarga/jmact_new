<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropColumnRegionalIdDeletedAtFromKeluhan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('keluhan', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
            $table->dropForeign('regional_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('keluhan', function (Blueprint $table) {
            $table->softDeletes();
        });
        
        Schema::table('keluhan', function (Blueprint $table) {
            $table->foreign('regional_id')->references('id')->on('master_regional')->onDelete('cascade');
        });
    }
}
