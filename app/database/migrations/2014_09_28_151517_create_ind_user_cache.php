<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndUserCache extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
    public function up()
    {
        //
        Schema::create('ind_user_cache',function(Blueprint $table){
            $table->bigIncrements('cacheId');
            $table->bigInteger('cacheUserId');
            $table->text('cacheValue');
            $table->timestamp('cacheAddedDate');
            $table->timestamp('cacheUpdatedDate');
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
        Schema::drop('ind_user_cache');
    }

}
