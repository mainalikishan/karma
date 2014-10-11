<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDummyUniversity extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('dummy_university',function(Blueprint $table){
            $table->increments('universityId');
            $table->string('universityCountryIsoCode',3);
            $table->string('universityName',255);
            $table->timestamp('universityAddedDate');
            $table->timestamp('universityUpdatedDate');

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
        Schema::drop('dummy_university');
    }

}
