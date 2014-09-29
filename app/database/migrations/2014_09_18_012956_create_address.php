<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddress extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
        Schema::create('address',function(Blueprint $table){
            $table->bigIncrements('addressId');
            $table->integer('addressCountryId');
            $table->string('addressName',100);
            $table->string('addressCoordinate',255);
            $table->timestamp('addressAddedDate');
            $table->timestamp('addressUpdatedDate');
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
        Schema::drop('address');
	}

}
