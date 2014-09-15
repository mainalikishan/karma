<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndPasswordLog extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
        Schema::create('ind_password_log', function(Blueprint $table)
        {
            $table->bigIncrements('logId');
            $table->bigInteger('userId');
            $table->string('passwordText');
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
        Schema::drop('ind_password_log');
	}

}
