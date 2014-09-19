<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobAppStatus extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
        Schema::create('job_app_status',function(Blueprint $table){
            $table->increments('statusId');
            $table->bigInteger('statusAppId');
            $table->enum('statusName',array('Hire','Shortlisted','Rejected','Selected'));
            $table->timestamp('statusAddedDate');
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
        Schema::drop('job_app_status');
	}

}
