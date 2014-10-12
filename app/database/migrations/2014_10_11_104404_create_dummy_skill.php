<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDummySkill extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('dummy_skill',function(Blueprint $table){
            $table->increments('skillId');
            $table->string('skillName',100);
            $table->timestamp('skillAddedDate');
            $table->timestamp('skillUpdatedDate');
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
        Schema::drop('dummy_skill');
    }

}
