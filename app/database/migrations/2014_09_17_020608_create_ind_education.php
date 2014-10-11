<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndEducation extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
        Schema::create('ind_education',function(Blueprint $table){
            $table->increments('eduId');
            $table->integer('eduLevelId');
            $table->integer('eduUserId');
            $table->string('eduUniversityId',100);
            $table->string('eduDegreeId',100);
            $table->integer('eduPassedYear');
            $table->timestamp('eduAddedDate');
            $table->timestamp('eduUpdatedDate');

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
        Schema::drop('ind_education');
	}

}
