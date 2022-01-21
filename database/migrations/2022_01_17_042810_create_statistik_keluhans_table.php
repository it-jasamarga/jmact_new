<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatistikKeluhansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statistik_keluhans');
    }
}
