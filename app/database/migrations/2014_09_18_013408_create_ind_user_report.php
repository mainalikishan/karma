<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndUserReport extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
    public function up()
    {
        //
        Schema::create('ind_user_report',function(Blueprint $table){
            $table->bigIncrements('reportId');
            $table->bigInteger('reportUserId');
            $table->bigInteger('reportByUserId');
            $table->enum('reportUserType',array('ind','cop'));
            $table->timestamp('reportAddedDate');
            $table->timestamp('reportUpdatedDate');
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
        Schema::drop('ind_user_report');
    }

}
