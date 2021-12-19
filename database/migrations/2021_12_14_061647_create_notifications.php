<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();

            $table->string('target_type')->nullable();
            $table->bigInteger('target_id')->nullable();
            
            $table->unsignedBigInteger('user_id')->nullable();
            
            $table->unsignedBigInteger('unit_id')->nullable();
            
            $table->string('title')->nullable();
            $table->longText('message')->nullable();

            $table->string('status')->default('Unread')->nullable();

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->foreign('unit_id')->references('id')->on('master_unit')->onDelete('cascade');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
