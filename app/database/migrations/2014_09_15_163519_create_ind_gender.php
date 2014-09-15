<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndGender extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
        Schema::create('ind_gender', function(Blueprint $table)
        {
            $table->increments('genderId');
            $table->string('genderName',10);
            $table->dateTime('genderAddedDate');
            $table->timestamp('genderUpdatedDate');

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
        Schema::drop('ind_gender');
	}

}
