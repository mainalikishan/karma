<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCopBlockUser extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
    public function up()
    {
        //
        Schema::create('message_receiver',function(Blueprint $table){
            $table->bigIncrements('messageId');
            $table->bigInteger('messageGroupId');
            $table->bigInteger('messageSenderId');
            $table->bigInteger('messageReceiverId');
            $table->text('messageText');
            $table->enum('messageDelete',array('Y','N'));
            $table->enum('messageReceiverType',array('ind','cop'));
            $table->enum('messageSenderType',array('ind','cop'));
            $table->timestamp('messageAddedDate');
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
        Schema::drop('message_receiver');
    }

}
