<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndBlockUser extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
        Schema::create('ind_block_user',function(Blueprint $table){
            $table->bigIncrements('blockId');
            $table->bigInteger('blockUserId');
            $table->integer('blockIndUserId');
            $table->enum('blockStatus',array('Y','N'));
            $table->date('blockDate');
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
        Schema::drop('ind_block_user');
	}

}
