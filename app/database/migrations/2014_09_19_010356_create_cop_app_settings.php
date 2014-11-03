<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCopAppSettings extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
    public function up()
    {
        Schema::create('cop_app_settings',function(Blueprint $table){
            $table->increments('settingId');
            $table->bigInteger('settinguserId');
            $table->char('settingLangCode',2)->default('en');
            $table->text('settingNotification');
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
        Schema::drop('cop_app_settings');
    }

}
