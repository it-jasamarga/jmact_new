<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterRenameTglKejadian extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('keluhan', function (Blueprint $table) {
            $table->renameColumn('tanggal_kejadian','tanggal_pelaporan')->nullable();
        });
        Schema::table('claim', function (Blueprint $table) {
            $table->renameColumn('tanggal_kejadian','tanggal_pelaporan')->nullable();
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
            $table->renameColumn('tanggal_pelaporan', 'tanggal_kejadian')->nullable();
        });
        Schema::table('claim', function (Blueprint $table) {
            $table->renameColumn('tanggal_pelaporan', 'tanggal_kejadian')->nullable();
        });
    }
}
