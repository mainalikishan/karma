<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewReportLog extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
    public function up()
    {
        //
        Schema::create('review_report_log',function(Blueprint $table){
            $table->bigIncrements('logId');
            $table->bigInteger('logReviewId');
            $table->bigInteger('logReportById');
            $table->enum('logUserType',array('ind','cop'));
            $table->text('logReportText');
            $table->timestamp('logAddedDate');
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
        Schema::drop('review_report_log');
    }
}
