<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndNotification extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('ind_notification', function (Blueprint $table) {
            $table->bigIncrements('notificationId');
            $table->bigInteger('notificationUserId');
            $table->text('notificationDetails');
            $table->enum('notificationTargetType', array('_JOB_APPLY_')); // _JOB_APPLY_ when apply by individual user to job
            $table->bigInteger('notificationTargetId');
            $table->enum('notificationView', array('Y', 'N'))->default('N');
            $table->timestamp('notificationAddedDate');
            $table->timestamp('notificationUpdatedDate');
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
        Schema::drop('ind_notification');
    }

}
