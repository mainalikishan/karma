<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessageGroup extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
    public function up()
    {
        //
        Schema::create('message_group',function(Blueprint $table){
            $table->bigIncrements('groupId');
            $table->bigInteger('groupStartById');
            $table->bigInteger('groupRecById');
            $table->enum('groupType',array('cop','ind'));
            $table->enum('groupChatRequest',array('Y','N'));
            $table->text('groupInitalMessage');
            $table->enum('groupBlock',array('Y','N'));
            $table->timestamp('settingAddedDate');
            $table->timestamp('settingUpdatedDate');
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
        Schema::drop('message_group');
    }
}
