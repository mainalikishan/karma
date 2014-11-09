<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobAppStatus extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_app_status', function (Blueprint $table) {
            $table->increments('statusId');
            $table->bigInteger('statusAppId');
            $table->enum('statusName', array('Applied', 'Shortlisted', 'Rejected', 'Hired'));
            $table->enum('statusCurrent', array('Y', 'N'))->default('N');
            $table->timestamp('statusAddedDate');
            $table->timestamp('statusUpdatedDate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('job_app_status');
    }

}
