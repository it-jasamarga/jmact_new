<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClaimPelangganTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_jenis_claim', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();

            $table->string('code')->nullable();
            $table->string('jenis_claim')->nullable();
            $table->boolean('active')->default(false)->nullable();
            
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('claim', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('no_tiket', 20)->nullable();
            $table->string('nama_pelanggan')->nullable();
            $table->string('nik_pelanggan', 30)->nullable();
            $table->string('alamat_pelanggan')->nullable();
            $table->string('kontak_pelanggan', 30)->nullable();
            
            $table->string('lokasi_kejadian')->nullable();
            $table->string('jenis_kendaraan')->nullable();
            $table->dateTime('tanggal_kejadian')->nullable();
            
            $table->string('keterangan_claim')->nullable();
            $table->string('no_polisi', 30)->nullable();
            $table->decimal('nominal_customer')->nullable();
            $table->decimal('nominal_final')->nullable();

            $table->unsignedBigInteger('jenis_claim_id');
            $table->unsignedBigInteger('ruas_id');
            $table->unsignedBigInteger('unit_id');
            $table->unsignedBigInteger('regional_id');
            $table->unsignedBigInteger('golongan_id');
            $table->unsignedBigInteger('status_id');
            $table->unsignedBigInteger('user_id');
            
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('jenis_claim_id')->references('id')->on('master_jenis_claim')->onDelete('cascade');
            $table->foreign('ruas_id')->references('id')->on('master_ruas')->onDelete('cascade');
            $table->foreign('unit_id')->references('id')->on('master_unit')->onDelete('cascade');
            $table->foreign('regional_id')->references('id')->on('master_regional')->onDelete('cascade');
            $table->foreign('golongan_id')->references('id')->on('master_golken')->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('master_status')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('claim');
        Schema::dropIfExists('master_jenis_claim');
    }
}
