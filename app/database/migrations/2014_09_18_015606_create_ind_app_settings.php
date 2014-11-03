<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndAppSettings extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
    public function up()
    {
        //
        Schema::create('ind_app_settings',function(Blueprint $table){
            $table->bigIncrements('settingId');
            $table->bigInteger('settingUserId');
            $table->text('settings');
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
        Schema::drop('ind_app_settings');
    }

}
