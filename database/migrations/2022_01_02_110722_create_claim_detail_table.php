<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClaimDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('claim_report', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();

            $table->unsignedBigInteger('claim_id')->nullable();
            $table->string('url_file')->nullable();
            $table->string('keterangan')->nullable();
            
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('claim_id')->references('id')->on('claim')->onDelete('cascade');
        });

        Schema::create('claim_history', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();

            $table->unsignedBigInteger('unit_id')->nullable();
            $table->unsignedBigInteger('regional_id')->nullable();
            $table->unsignedBigInteger('ruas_id')->nullable();
            $table->unsignedBigInteger('claim_id')->nullable();
            $table->bigInteger('tipe')->nullable();
            $table->unsignedBigInteger('status_id')->nullable();
            $table->string('provider')->nullable();
            
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('status_id')->references('id')->on('master_status')->onDelete('cascade');
            $table->foreign('claim_id')->references('id')->on('claim')->onDelete('cascade');
            $table->foreign('ruas_id')->references('id')->on('master_ruas')->onDelete('cascade');

            $table->foreign('unit_id')->references('id')->on('master_unit')->onDelete('cascade');
            $table->foreign('regional_id')->references('id')->on('master_regional')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('claim_detail');
    }
}
