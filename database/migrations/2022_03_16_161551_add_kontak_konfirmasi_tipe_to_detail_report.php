<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKontakKonfirmasiTipeToDetailReport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detail_report', function (Blueprint $table) {
            $table->longText('keterangan_reject')->nullable()->after('keterangan');
            $table->string('kontak_pelanggan', 225)->nullable()->after('keterangan_reject');
            $table->string('tipe_penyelesaian', 225)->nullable()->after('kontak_pelanggan');
            //
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
            $table->dropColumn(['kontak_pelanggan']);
            $table->dropColumn(['keterangan_reject']);
            $table->dropColumn(['tipe_penyelesaian']);
        });
    }
}
