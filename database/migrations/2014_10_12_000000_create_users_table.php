<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('username')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('password')->nullable();
            $table->boolean('status_id')->nullable();
            
            $table->longText('token')->nullable();
            $table->integer('expires')->nullable();
            
            $table->timestamp('last_login')->nullable();
            
            $table->string('kd_comp')->nullable();
            $table->string('npp')->nullable();

            $table->unsignedBigInteger('unit_id')->nullable();
            $table->longText('device_id')->nullable();

            $table->boolean('active')->default(true)->nullable();
            $table->boolean('is_mobile')->nullable();
            $table->boolean('is_ldap')->nullable();
         
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
        Schema::dropIfExists('users');
    }
}
