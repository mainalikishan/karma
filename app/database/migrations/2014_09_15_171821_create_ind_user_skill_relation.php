<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndUserSkillRelation extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('ind_user_skills_relation', function (Blueprint $table) {
            $table->bigIncrements('relationId');
            $table->bigInteger('relationUserId');
            $table->integer('relationSkillId');
            $table->timestamp('relationAddedDate');
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
        Schema::drop('ind_user_skills_relation');
    }

}
