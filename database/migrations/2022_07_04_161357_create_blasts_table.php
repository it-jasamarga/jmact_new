<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlastsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blasts', function (Blueprint $table) {
            $table->id();

            $table->string('no_telepon');
            $table->string('nama');
            $table->string('no_tiket');
            $table->text('attributes')->nullable();
            $table->integer('blast_state')->default(0);
            $table->string('blast_text')->nullable();

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
        Schema::dropIfExists('blasts');
    }
}
