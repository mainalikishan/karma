<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobCache extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
        Schema::create('job_cache',function(Blueprint $table){
            $table->increments('cacheId');
            $table->bigInteger('userId');
            $table->bigInteger('jobId');
            $table->text('cacheDetails');
            $table->timestamp('cacheAddedDate');
            $table->timestamp('cacheUpdatedDate');
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
        Schema::drop('job_cache');
	}
}
