<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCopReportLog extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
        Schema::create('cop_report_log',function(Blueprint $table){
            $table->bigIncrements('logId');
            $table->bigInteger('logUserId');
            $table->bigInteger('logReportById');
            $table->text('logText');
            $table->timestamp('logAddedDate');
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
        Schema::drop('cop_report_log');
	}

}
