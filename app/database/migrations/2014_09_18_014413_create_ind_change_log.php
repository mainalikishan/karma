<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndChangeLog extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
    public function up()
    {
        //
        Schema::create('ind_user_change_log',function(Blueprint $table){
            $table->bigIncrements('logId');
            $table->bigInteger('logUserId');
            $table->enum('logKey',array('DOB','FNAME','LNAME','PASSWORD','COUNTRY','ADDRESS','SUMMARY'));
            $table->text('logChangeValue');
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
        Schema::drop('ind_user_change_logon');
    }
}
