<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLanguage extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
    public function up()
    {
        //
        Schema::create('language',function(Blueprint $table){
            $table->increments('languageId');
            $table->string('languageName',100);
            $table->string('languageCode',5);
            $table->timestamp('languageAddedDate');
            $table->timestamp('languageUpdatedDate');
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
        Schema::drop('language');
    }


}
