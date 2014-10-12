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
        Schema::create('ind_user',function(Blueprint $table){
            $table->bigIncrements('userId');
            $table->integer('userGenderId');
            $table->string('userCountryISO', 5);
            $table->integer('userAddressId');
            $table->text('userAddressCoordinate');
            $table->text('userDynamicAddressCoordinate'); // it will updated dynamically
            $table->integer('userProfessionId');
            $table->text('userSkillIds');
            $table->string('userFname',80);
            $table->string('userLname',80);
            $table->string('userEmail',80);
            $table->string('userPassword',100);
            $table->string('userToken',100);
            $table->date('userDOB');
            $table->bigInteger('userOauthId');
            $table->enum('userOauthType', array('Facebook', 'Twitter','LinkedIn'));
            $table->mediumText('userSummary');
            $table->text('userPic');
            $table->dateTime('userRegDate');
            $table->dateTime('userLastLogin');
            $table->integer('userLoginCount');
            $table->string('userLastLoginIp',20);
            $table->timestamp('userLastUpdated');
            $table->enum('userEmailVerification',array('Y','N'))->default('N');
            $table->integer('userEmailVerificationCode');
            $table->enum('userStatus',array('Active','Block'))->default('Active');
            $table->enum('userAccountStatus',array('Active','perDeactivate','tempDeactivate'))->default('Active');
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
