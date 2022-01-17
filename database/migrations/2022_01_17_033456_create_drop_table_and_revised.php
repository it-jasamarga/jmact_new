<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDropTableAndRevised extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('keluhan_report');
        Schema::dropIfExists('keluhan_history');
        Schema::dropIfExists('claim_report');
        Schema::dropIfExists('claim_history');

        Schema::create('detail_report', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();

            $table->unsignedBigInteger('keluhan_id')->nullable();
            $table->string('url_file')->nullable();
            $table->string('keterangan')->nullable();
            
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('keluhan_id')->references('id')->on('keluhan')->onDelete('cascade');
        });

        Schema::create('detail_history', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();

            $table->unsignedBigInteger('unit_id')->nullable();
            $table->unsignedBigInteger('regional_id')->nullable();
            $table->unsignedBigInteger('ruas_id')->nullable();
            $table->unsignedBigInteger('keluhan_id')->nullable();
            $table->unsignedBigInteger('claim_id')->nullable();
            $table->bigInteger('tipe')->nullable();
            $table->unsignedBigInteger('status_id')->nullable();
            $table->string('provider')->nullable();
            
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('status_id')->references('id')->on('master_status')->onDelete('cascade');
            $table->foreign('keluhan_id')->references('id')->on('keluhan')->onDelete('cascade');
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
        Schema::dropIfExists('detail_report');
        Schema::dropIfExists('detail_history');

        Schema::create('keluhan_report', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();

            $table->unsignedBigInteger('keluhan_id')->nullable();
            $table->string('url_file')->nullable();
            $table->string('keterangan')->nullable();
            
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('keluhan_id')->references('id')->on('keluhan')->onDelete('cascade');
        });

        Schema::create('keluhan_history', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();

            $table->unsignedBigInteger('unit_id')->nullable();
            $table->unsignedBigInteger('regional_id')->nullable();
            $table->unsignedBigInteger('ruas_id')->nullable();
            $table->unsignedBigInteger('keluhan_id')->nullable();
            $table->unsignedBigInteger('claim_id')->nullable();
            $table->bigInteger('tipe')->nullable();
            $table->unsignedBigInteger('status_id')->nullable();
            $table->string('provider')->nullable();
            
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('status_id')->references('id')->on('master_status')->onDelete('cascade');
            $table->foreign('keluhan_id')->references('id')->on('keluhan')->onDelete('cascade');
            $table->foreign('ruas_id')->references('id')->on('master_ruas')->onDelete('cascade');

            $table->foreign('unit_id')->references('id')->on('master_unit')->onDelete('cascade');
            $table->foreign('regional_id')->references('id')->on('master_regional')->onDelete('cascade');

        });
    }
}
