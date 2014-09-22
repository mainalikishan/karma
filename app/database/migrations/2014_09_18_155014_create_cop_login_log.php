<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCopLoginLog extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
        Schema::create('cop_login_log',function(Blueprint $table){
            $table->bigIncrements('logId');
            $table->bigInteger('loginUserId');
            $table->text('logLoginAgent');
            $table->string('logLoginIp', 50);
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
        Schema::drop('cop_login_log');
	}

}
