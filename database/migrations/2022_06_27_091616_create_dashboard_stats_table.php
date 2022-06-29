<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDashboardStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('dashboard_stats', function (Blueprint $table) {
        //     $table->id();
        //     $table->timestamps();
        // });


        \DB::statement("
            CREATE OR REPLACE VIEW `dashboard_stats` AS
            SELECT
                RE.name AS regional,
                RU.name AS ruas,
                CASE
                    WHEN (MS.status = 'On Progress' OR MS.status = 'Submit Report') AND KE.deadline >= NOW() THEN 'OnProgress'
                    WHEN (MS.status = 'On Progress' OR MS.status = 'Submit Report') AND KE.deadline < NOW() THEN 'Overtime'
                    WHEN MS.status = 'Closed' AND
                        DATEDIFF(
                            (SELECT created_at FROM detail_history WHERE keluhan_id = KE.id AND status_id = (SELECT id FROM master_status WHERE status='Closed' AND type=1)),
                            (SELECT created_at FROM detail_history WHERE keluhan_id = KE.id AND status_id = (SELECT id FROM master_status WHERE status='On Progress' AND type=1))
                        ) <=3 THEN 'OnTime'
                    WHEN MS.status = 'Closed' AND
                        DATEDIFF(
                            (SELECT created_at FROM detail_history WHERE keluhan_id = KE.id AND status_id = (SELECT id FROM master_status WHERE status='Closed' AND type=1)),
                            (SELECT created_at FROM detail_history WHERE keluhan_id = KE.id AND status_id = (SELECT id FROM master_status WHERE status='On Progress' AND type=1))
                        ) >3 THEN 'BehindTime'
                END AS group_info,
                COUNT(KE.no_tiket) AS total
            FROM
                keluhan KE
                LEFT JOIN master_status MS ON MS.id = KE.status_id
                LEFT JOIN master_ruas RU ON RU.id = KE.ruas_id
                LEFT JOIN master_ro RO ON RO.id = RU.ro_id
                LEFT JOIN master_regional RE ON RE.id = RO.regional_id
            WHERE
                KE.status_id >= (SELECT id FROM master_status WHERE status='On Progress' AND type=1)
                AND KE.status_id <= (SELECT id FROM master_status WHERE status='Closed' AND type=1)
            GROUP BY
                RE.name,
                RU.name,
                group_info

        ");


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('dashboard_stats');
        \DB::statement("
            DROP VIEW `dashboard_stats`
        ");
    }
}
