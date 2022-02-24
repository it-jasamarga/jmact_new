<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropColumnDeletedatFromDetailreport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detail_report', function (Blueprint $table) {
            $table->longText('keterangan')->nullable()->change();
            $table->dropColumn(['deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detail_report', function (Blueprint $table) {
            $table->softDeletes();
        });
    }
}
