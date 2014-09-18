<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCopInternalLog extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
        Schema::create('cop_internal_log',function(Blueprint $table){
            $table->bigIncrements('logId');
            $table->bigInteger('loginUserId');
            $table->text('logDetails');
            $table->timestamp('logAddedDate');
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
        Schema::drop('cop_internal_log');
	}

}
