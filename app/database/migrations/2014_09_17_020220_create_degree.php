<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDegree extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
        Schema::create('degree',function(Blueprint $table){

            $table->increments('degreeId');
            $table->string('degreeName',200);
            $table->timestamp('degreeAddedDate');
            $table->timestamp('degreeUpdatedDate');
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
        Schema::drop('degree');
	}

}
