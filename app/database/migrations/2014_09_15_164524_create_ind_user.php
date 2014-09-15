<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndUser extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
        Schema::create('ind_user',function(Blueprint $table){
            $table->bigIncrements('userId');
            $table->integer('userGenderId');
            $table->integer('userCountryId');
            $table->integer('userAddressId');
            $table->integer('userJobTitleId');
            $table->string('userFname',80);
            $table->string('userLname',80);
            $table->string('userEmail',80);
            $table->string('userPassword',50);
            $table->date('userDOB');
            $table->bigInteger('userOuathId');
            $table->enum('userOuathType', array('Facebook', 'Twitter','LinkedIn'));
            $table->mediumText('userSummary');
            $table->dateTime('userRegDate');
            $table->dateTime('userLastLogin');
            $table->integer('userLoginCount');
            $table->string('userLastLoginIp',20);
            $table->timestamp('userLastUpdated');
            $table->enum('userStatus',array('Active','block'));
            $table->enum('userAccountStatus',array('perDeactivate','tempDeactivate'));
            $table->integer('userReportCount');
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
        Schema::drop('ind_user');
	}

}
