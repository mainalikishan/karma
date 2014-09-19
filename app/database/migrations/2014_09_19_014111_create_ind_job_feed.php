<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndJobFeed extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
        Schema::create('ind_job_feed',function(Blueprint $table){
            $table->bigIncrements('feedId');
            $table->text('feedDetails');
            $table->text('feedSkills');
            $table->float('feedSalary');
            $table->text('feedLocation');
            $table->timestamp('feedAddedDate');
            $table->timestamp('feedUpdatedDate');
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
        Schema::drop('ind_job_feed');
	}

}
