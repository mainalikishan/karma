<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReview extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
    public function up()
    {
        //
        Schema::create('profile_review',function(Blueprint $table){
            $table->bigIncrements('reviewId');
            $table->bigInteger('reviewById');
            $table->bigInteger('reviewToId');
            $table->enum('reviewUserType',array('ind','cop'));
            $table->text('reviewText');
            $table->float('reviewRatingValue');
            $table->integer('reviewReportCount');
            $table->enum('reviewReportStatus',array('Y','N'));
            $table->timestamp('reviewAddedDate');
            $table->timestamp('reviewUpdatedDate');
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
        Schema::drop('profile_review');
    }
}
