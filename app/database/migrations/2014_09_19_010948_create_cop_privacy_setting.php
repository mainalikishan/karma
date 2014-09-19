<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCopPrivacySetting extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
    public function up()
    {
        //
        Schema::create('cop_privacy_setting',function(Blueprint $table){
            $table->bigIncrements('settingId');
            $table->bigInteger('settingUserId');
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
        Schema::drop('cop_privacy_setting');
    }

}
