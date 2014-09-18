<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobApp extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
        Schema::create('job_app',function(Blueprint $table){
            $table->bigIncrements('appId');
            $table->bigInteger('appCopUserId');
            $table->bigInteger('appIndUserId');
            $table->bigInteger('appJobId');
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
        Schema::drop('job_app');
	}

}
