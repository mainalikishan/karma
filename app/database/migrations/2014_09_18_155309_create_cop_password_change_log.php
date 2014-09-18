<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCopPasswordChangeLog extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
        Schema::create('cop_password_change_log',function(Blueprint $table){
            $table->bigIncrements('logId');
            $table->bigInteger('loginUserId');
            $table->string('logOldPassword',100);
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
        Schema::drop('cop_password_change_log');
	}

}
