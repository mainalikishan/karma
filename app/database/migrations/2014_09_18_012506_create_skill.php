<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSkill extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
        Schema::create('skill',function(Blueprint $table){
            $table->increments('skillId');
            $table->string('skillProfessionId',100);
            $table->string('skillName',100);
            $table->timestamp('skillAddedDate');
            $table->timestamp('skillUpdatedDate');
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
        Schema::drop('skill');
	}

}
