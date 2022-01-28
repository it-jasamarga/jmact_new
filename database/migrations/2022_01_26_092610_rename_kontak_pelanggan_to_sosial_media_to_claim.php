<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameKontakPelangganToSosialMediaToClaim extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('claim', function (Blueprint $table) {
            $table->renameColumn('kontak_pelanggan', 'sosial_media');
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
            $table->dropColumn(['sosial_media']);
        });
    }
}
