<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCharacteristicsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Characteristic', function($table) {
			$table->increments('id');
			$table->string('name');
			$table->integer('count');
			$table->timestamps();
		});

		Schema::create('CompanyCharacteristic', function($table) {
			$table->increments('id');
			$table->integer('characteristicId')->unsigned();
			$table->integer('companyId')->unsigned();
			$table->integer('count');
			$table->timestamps();
			$table->foreign('characteristicId')->references('id')->on('Characteristic');
			$table->foreign('companyId')->references('id')->on('Company');
		});

		Schema::create('User', function($table) {
			$table->increments('id');
			$table->string('email');
			$table->string('password');
			$table->timestamps();
		});

		Schema::create('UserVote', function($table) {
			$table->increments('id');
			$table->integer('userId')->unsigned();
			$table->integer('companyCharacteristicId')->unsigned();
			$table->tinyInteger('statusId')->unsigned()->default(1);
			$table->timestamps();
			$table->foreign('userId')->references('id')->on('User');
			$table->foreign('companyCharacteristicId')->references('id')->on('CompanyCharacteristic');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('UserVote');
		Schema::drop('User');
		Schema::drop('CompanyCharacteristic');
		Schema::drop('Characteristic');
	}

}
