<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndExperience extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
        Schema::create('ind_experience',function(Blueprint $table){
            $table->bigIncrements('expId');
            $table->bigInteger('expUserId');
            $table->string('expTitle',100);
            $table->enum('expType',array('company','freelancer'));
            $table->string('expCompany',100);
            $table->enum('expCurrent',array('Y','N'));
            $table->date('expStartDate');
            $table->date('expEndDate');
            $table->timestamp('expAddedDate');
            $table->timestamp('expUpdatedDate');
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
        Schema::drop('ind_experience');
	}

}
