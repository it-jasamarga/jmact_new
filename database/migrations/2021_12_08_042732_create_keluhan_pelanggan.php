<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeluhanPelanggan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keluhan', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('no_tiket')->nullable();
            $table->string('nama_cust')->nullable();
            $table->string('kontak_cust')->nullable();
            $table->string('lokasi_kejadian')->nullable();
            $table->dateTime('tanggal_kejadian')->nullable();
            $table->longText('keterangan_keluhan')->nullable();

            $table->unsignedBigInteger('sumber_id');
            $table->unsignedBigInteger('bidang_id');
            $table->unsignedBigInteger('ruas_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('unit_id');
            $table->unsignedBigInteger('regional_id');
            $table->unsignedBigInteger('golongan_id');
            $table->unsignedBigInteger('status_id');
            
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('sumber_id')->references('id')->on('master_sumber')->onDelete('cascade');
            $table->foreign('bidang_id')->references('id')->on('master_bk')->onDelete('cascade');
            $table->foreign('ruas_id')->references('id')->on('master_ruas')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('regional_id')->references('id')->on('master_regional')->onDelete('cascade');
            $table->foreign('unit_id')->references('id')->on('master_unit')->onDelete('cascade');
            $table->foreign('golongan_id')->references('id')->on('master_golken')->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('master_status')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('keluhan');
    }
}
