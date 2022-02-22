<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartiksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('cartiks', function (Blueprint $table) {
        //     $table->id();
        //     $table->timestamps();
        // });


        \DB::statement("
            CREATE VIEW `cartiks` AS
            SELECT 
                `keluhan`.`no_tiket` AS `no_tiket`,
                `keluhan`.`status_id` AS `status_id`,
                'K' AS `type`
            FROM
                `keluhan` 
            UNION
            SELECT 
                `claim`.`no_tiket` AS `no_tiket`,
                `claim`.`status_id` AS `status_id`,
                'C' AS `type`
            FROM
                `claim`
        ");


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('cartiks');
        \DB::statement("
            DROP VIEW IF EXISTS `cartiks`
        ");
    }
}
