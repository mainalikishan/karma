<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCopProfileViewLog extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
        Schema::create('cop_profile_view_log',function(Blueprint $table){
            $table->bigIncrements('logId');
            $table->bigInteger('logViewerId');
            $table->bigInteger('logUserId');
            $table->enum('logUserType',array('cop','ind'));
            $table->timestamp('logAddedDate');
            $table->timestamp('logUpdatedDate');
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
        Schema::drop('cop_profile_view_log');
	}

}
