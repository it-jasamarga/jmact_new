<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKontakPelangganKonfirmasiPelangganToDetailReport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detail_report', function (Blueprint $table) {
            $table->renameColumn('keterangan_reject', 'konfirmasi_pelanggan')->nullable()->after('keterangan');
            $table->unsignedBigInteger('kontak_pelanggan')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detail_report', function (Blueprint $table) {
            $table->dropColumn(['konfirmasi_pelanggan']);
            $table->dropColumn(['kontak_pelanggan']);
            $table->dropColumn(['tipe_penyelesaian']);
        });
    }
}
