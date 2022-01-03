<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_sumber', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();

            $table->string('code')->nullable();
            $table->longText('description')->nullable();
            
            $table->boolean('active')->default(false)->nullable();
            
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('master_regional', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();


            $table->string('name')->nullable();
            $table->boolean('active')->default(false)->nullable();
            
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('master_ro', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();

            $table->unsignedBigInteger('regional_id')->nullable();

            $table->string('name')->nullable();
            $table->boolean('active')->default(false)->nullable();
            
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('regional_id')
                ->references('id')
                ->on('master_regional')
                ->onDelete('cascade');

        });

        Schema::create('master_ruas', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();

            $table->unsignedBigInteger('ro_id')->nullable();

            $table->string('name')->nullable();
            $table->boolean('active')->default(false)->nullable();
            
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('ro_id')
                ->references('id')
                ->on('master_ro')
                ->onDelete('cascade');
        });

        Schema::create('master_golken', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();

            $table->string('golongan')->nullable();
            $table->longText('description')->nullable();
            $table->boolean('active')->default(false)->nullable();
            
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('master_unit', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();

            $table->string('code')->nullable();
            $table->string('unit')->nullable();
            $table->boolean('active')->default(false)->nullable();
            
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('master_status', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();

            $table->string('code')->nullable();
            $table->string('status')->nullable();
            $table->boolean('active')->default(false)->nullable();
            
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('master_bk', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();

            $table->string('bidang')->nullable();
            $table->string('keluhan')->nullable();
            $table->boolean('active')->default(false)->nullable();
            
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_sumber');
        Schema::dropIfExists('master_ruas');
        Schema::dropIfExists('master_ro');
        Schema::dropIfExists('master_regional');
        Schema::dropIfExists('master_golken');
        Schema::dropIfExists('master_unit');
        Schema::dropIfExists('master_status');
        Schema::dropIfExists('master_bk');
        Schema::dropIfExists('master_jenis_claim');
    }
}
