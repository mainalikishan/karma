<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfession extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profession', function(Blueprint $table)
        {
            $table->increments('professionId');
            $table->string('professionName',80);
            $table->dateTime('professionAddedDate');
            $table->timestamp('professionUpdatedDate');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
    error_reporting(E_ALL); ini_set('display_errors', 1);
    Kishan Mainali

    Kishan Mainali

     */
    public function down()
    {
        //
        Schema::drop('profession');
    }

}
