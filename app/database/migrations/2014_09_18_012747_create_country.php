<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountry extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
        //
        Schema::create('country',function(Blueprint $table){
            $table->increments('idCountry');
            $table->char('countryCode',3);
            $table->string('countryName',100);
            $table->char('currencyCode',3);
            $table->string('population',20);
            $table->char('fipsCode',2);
            $table->char('isoNumeric',4);
            $table->string('north',30);
            $table->string('south',30);
            $table->string('east',30);
            $table->string('west',30);
            $table->string('capital',30);
            $table->string('continentName',15);
            $table->char('continent',2);
            $table->string('areaInSqKm',20);
            $table->string('languages',30);
            $table->char('isoAlpha3',3);
            $table->integer('geonameId');
            $table->timestamp('countryAddedDate');
            $table->timestamp('countryUpdatedDate');
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
        Schema::drop('country');
	}

}
