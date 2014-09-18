<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndustryType extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
        Schema::create('industry_type',function(Blueprint $table){
            $table->increments('industryTypeId');
            $table->string('industryTypeName',100);
            $table->timestamp('industryTypeAddedDate');
            $table->timestamp('industryTypeUpdatedDate');

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
        Schema::drop('industry_type');
	}

}
