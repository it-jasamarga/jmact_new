<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWaktuPengerjaanToKeluhanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('keluhan', function (Blueprint $table) {
            $table->dateTime('mulai_pengerjaan')->nullable()->after('keterangan_keluhan');
            $table->dateTime('selesai_pengerjaan')->nullable()->after('mulai_pengerjaan');
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
            $table->dropColumn(['mulai_pengerjaan']);
            $table->dropColumn(['selesai_pengerjaan']);
        });
    }
}
