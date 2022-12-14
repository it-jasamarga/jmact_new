<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPenyelesaianToClaim extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('claim', function (Blueprint $table) {
            $table->string('penyelesaian')->nullable()->after('keterangan_reject');
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
            $table->dropColumn('penyelesaian');
        });
    }
}
