<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountry extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
        //
        Schema::create('country',function(Blueprint $table){
            $table->increments('countryId');
            $table->string('countryName',100);
            $table->string('countryISOCode',5);
            $table->timestamp('countryAddedDate');
            $table->timestamp('countryUpdatedDate');
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
        Schema::drop('country');
	}

}
