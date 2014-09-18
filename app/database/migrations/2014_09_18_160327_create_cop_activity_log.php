<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCopActivityLog extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
    public function up()
    {
        //
        Schema::create('cop_activity_log',function(Blueprint $table){
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
        Schema::drop('cop_activity_log');
    }

}
