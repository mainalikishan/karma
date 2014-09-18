<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndHire extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
        Schema::create('ind_hire',function(Blueprint $table){
            $table->bigIncrements('hireId');
            $table->bigInteger('hireById');
            $table->bigInteger('hireToId');
            $table->enum('hireByUserType',array('cop','ind'));
            $table->dateTime('hireDate');
            $table->enum('hireAccept',array('Y','N'));
            $table->dateTime('hireAcceptDate');
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
        Schema::drop('ind_hire');
	}

}
