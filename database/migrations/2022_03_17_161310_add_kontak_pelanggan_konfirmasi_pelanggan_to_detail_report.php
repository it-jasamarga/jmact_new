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
            $table->dropColumn(['keterangan_reject']);
            $table->dropColumn(['kontak_pelanggan']);
            $table->dropColumn(['tipe_penyelesaian']);
            $table->longText('konfirmasi_pelanggan')->nullable()->after('keterangan');
            $table->unsignedBigInteger('kontak_pelanggan')->after('konfirmasi_pelanggan');
            $table->string('tipe_penyelesaian', 225)->nullable()->after('kontak_pelanggan');
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
