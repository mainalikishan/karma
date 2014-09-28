<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCopChangeLog extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
        Schema::create('cop_change_log',function(Blueprint $table){
            $table->bigIncrements('logId');
            $table->bigInteger('logUserId');
            $table->enum('logKey',array('CNAME','COUNTRY','ADDRESS','PHONE','PASSWORD'));
            $table->string('logValue',100);
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
        Schema::drop('cop_change_log');
	}

}
