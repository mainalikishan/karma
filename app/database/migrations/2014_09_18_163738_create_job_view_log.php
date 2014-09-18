<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobViewLog extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
        Schema::create('job_view_log',function(Blueprint $table){
            $table->bigIncrements('logId');
            $table->bigInteger('logJobId');
            $table->bigInteger('logViewByUserId');
            $table->timestamp('appAddedDate');
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
        Schema::drop('job_view_log');
	}

}
