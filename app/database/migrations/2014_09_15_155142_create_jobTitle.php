<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobTitle extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('job_title', function(Blueprint $table)
        {
            $table->increments('jobTitleId');
            $table->string('jobTitleName',80);
            $table->dateTime('jobTitleAddedDate');
            $table->timestamp('jobTitleUpdatedDate');

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
        Schema::drop('job_title');
	}

}
