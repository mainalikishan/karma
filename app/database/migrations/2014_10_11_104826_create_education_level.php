<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEducationLevel extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('education_level',function(Blueprint $table){
            $table->increments('levelId');
            $table->string('levelName',100);
            $table->timestamp('levelAddedDate');
            $table->timestamp('levelUpdatedDate');
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
        Schema::drop('education_level');
    }

}
