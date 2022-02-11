<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropTableStatistikKeluhansKeluhanUnit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('keluhan_unit');
        Schema::dropIfExists('statistik_keluhans');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('keluhan_unit', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();

            $table->unsignedBigInteger('keluhan_id')->nullable();
            
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->unsignedBigInteger('regional_id')->nullable();
            
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('keluhan_id')->references('id')->on('keluhan')->onDelete('cascade');
            $table->foreign('unit_id')->references('id')->on('master_unit')->onDelete('cascade');
            $table->foreign('regional_id')->references('id')->on('master_regional')->onDelete('cascade');

        });

        Schema::create('statistik_keluhans', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('ruas_id');
            $table->unsignedBigInteger('Overtime');
            $table->unsignedBigInteger('OnProgress');
            $table->unsignedBigInteger('OnTime');
            $table->unsignedBigInteger('BehindTime');
            $table->unsignedBigInteger('OnQueue');
            $table->text('ExtendedInfo')->nullable();
            $table->unsignedSmallInteger('Bulan');
            $table->unsignedSmallInteger('Tahun');

            $table->timestamps();
        });
    }
}
