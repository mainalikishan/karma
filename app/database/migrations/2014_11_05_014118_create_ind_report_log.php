<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndReportLog extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('ind_report_log', function (Blueprint $table) {
            $table->bigIncrements('logId');
            $table->bigInteger('logUserId');
            $table->bigInteger('logReportById');
            $table->enum('logUserType', array('ind', 'cop'));
            $table->text('logText');
            $table->timestamp('logAddedDate');
            $table->timestamp('logUpdatedDate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::drop('ind_report_log');
    }

}
