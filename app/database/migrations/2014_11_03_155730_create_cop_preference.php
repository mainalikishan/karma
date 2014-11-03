<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCopPreference extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('cop_preference', function (Blueprint $table) {
            $table->bigIncrements('preferenceId');
            $table->bigInteger('preferenceUserId');
            $table->text('preferenceData');
            $table->timestamp('preferenceAddedDate');
            $table->timestamp('preferenceUpdatedDate');
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
        Schema::drop('cop_preference');
    }

}
