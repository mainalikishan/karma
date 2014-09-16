<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndProfieViewLog extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
        Schema::create('ind_profile_view_log',function(Blueprint $table){
            $table->bigIncrements('logId');
            $table->bigInteger('logUserId');
            $table->bigInteger('userId');
            $table->enum('logViewType',array('cop','ind'));
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
        Schema::drop('ind_profile_view_log');
	}

}
