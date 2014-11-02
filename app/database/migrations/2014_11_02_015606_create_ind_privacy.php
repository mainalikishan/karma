<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndPrivacy extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
    public function up()
    {
        //
        Schema::create('ind_privacy',function(Blueprint $table){
            $table->bigIncrements('privacyId');
            $table->bigInteger('privacyUserId');
            $table->text('privacyData');
            $table->timestamp('privacyAddedDate');
            $table->timestamp('privacyUpdatedDate');
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
        Schema::drop('ind_privacy');
    }


}
