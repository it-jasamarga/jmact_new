<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterKeluhanClaimToMasterSumber extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('master_sumber', function (Blueprint $table) {
            $table->boolean('keluhan')->nullable()->after('description');
            $table->boolean('claim')->nullable()->after('keluhan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('master_sumber', function (Blueprint $table) {
            $table->dropColumn(['keluhan']);
            $table->dropColumn(['claim']);
        });
    }
}
