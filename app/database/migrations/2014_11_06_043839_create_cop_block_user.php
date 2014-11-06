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
        Schema::create('cop_block_user',function(Blueprint $table){
            $table->bigIncrements('blockId');
            $table->bigInteger('blockUserId');
            $table->integer('blockByUserId');
            $table->enum('blockUserType',array('ind','cop'));
            $table->enum('blockStatus',array('Y','N'))->default('Y');
            $table->dateTime('blockAddedDate');
            $table->dateTime('blockUpdatedDate');
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
        Schema::drop('cop_block_user');
    }

}
