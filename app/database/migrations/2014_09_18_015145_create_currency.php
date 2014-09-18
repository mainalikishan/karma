<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurrency extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
    public function up()
    {
        //
        Schema::create('currency',function(Blueprint $table){
            $table->increments('currencyId');
            $table->string('currencyName',30);
            $table->string('currencyCode',5);
            $table->timestamp('currencyAddedDate');
            $table->timestamp('currencyUpdatedDate');
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
        Schema::drop('currency');
    }

}
