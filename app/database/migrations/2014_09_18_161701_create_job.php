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
            $table->integer('jobTypeId');
            $table->string('jobTitle',255);
            $table->integer('jobOpen');
            $table->text('jobSkills');
            $table->date('jobExpDate');
            $table->enum('jobExp',array('0','1','2','3','4','5'));
            $table->timestamp('jobAddedDate');
            $table->timestamp('jobUpdatedDate');
            $table->integer('jobViewCount');
            $table->integer('jobAppCount');
            $table->integer('jobShortListCount');
            $table->integer('jobHireCount');
            $table->integer('jobRejectCount');
            $table->enum('jobDelete',array('Y','N'))->default('N');
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
