<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNoTeleponUrlFileToKeluhan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('keluhan', function (Blueprint $table) {
            $table->string('no_telepon')->nullable()->after('nama_cust');
            $table->string('url_file')->nullable()->after('keterangan_keluhan');
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
            $table->dropColumn(['no_telepon']);
            $table->dropColumn(['url_file']);
        });
    }
}
