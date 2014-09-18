<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJob extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
        Schema::create('job',function(Blueprint $table){
            $table->bigIncrements('jobId');
            $table->bigInteger('jobUserId');
            $table->integer('jobCountryId');
            $table->integer('jobAddressId');
            $table->text('jobSkills');
            $table->date('jobExpDate');
            $table->timestamp('jobAddedDate');
            $table->timestamp('jobUpdatedDate');
            $table->integer('jobViewCount');
            $table->integer('jobAppCount');
            $table->integer('jobShortListCount');
            $table->integer('jobHireCount');
            $table->integer('jobRejectCount');
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
        Schema::drop('job');
	}

}
