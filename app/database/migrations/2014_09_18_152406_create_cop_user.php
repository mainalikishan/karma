<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCopUser extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
        Schema::create('cop_user',function(Blueprint $table){

            $table->bigIncrements('userId');
            $table->integer('userIndustryTypeId');
            $table->integer('userCountryId');
            $table->integer('userAddressId');
            $table->text('userAddressCoordinate');
            $table->text('userDynamicAddressCoordinate');/// it is updated dynamically
            $table->string('userCompanyPhone',15);
            $table->string('userCompanyName',100);
            $table->string('userEmail',100);
            $table->string('userPassword',100);
            $table->string('userToken',100);
            $table->string('userCoverPic',100);
            $table->string('userProfilePic',100);
            $table->text('userSummary');
            $table->timestamp('userRegDate');
            $table->timestamp('userUpdatedDate');
            $table->integer('userLoginCount');
            $table->string('userLoginIp',20);
            $table->bigInteger('userOauthId');
            $table->string('userOuthType',20);
            $table->enum('userStatus',array('Y','N'))->default('Y');
            $table->enum('userEmailVerification',array('Y','N'))->default('N');
            $table->integer('userEmailVerificationCode');
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
        Schema::drop('cop_user');
	}

}
