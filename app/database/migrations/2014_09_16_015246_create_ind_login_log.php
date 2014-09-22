<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndLoginLog extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('ind_login_log', function (Blueprint $table) {
            $table->bigIncrements('logId');
            $table->bigInteger('logUserId');
            $table->string('logIp', 20);
            $table->text('logAgent');
            $table->string('logLoginIp', 50);
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
        Schema::drop('ind_login_log');
    }

}
