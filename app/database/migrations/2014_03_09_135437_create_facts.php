<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacts extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('Fact', function($table) {
			$table->increments('id');
			$table->string('name');
			$table->timestamps();
		});

		Schema::create('CompanyFact', function($table) {
			$table->increments('id');
			$table->integer('companyId')->unsigned();
			$table->integer('factId')->unsigned();
			$table->string('value');
			$table->foreign('companyId')->references('id')->on('Company');
			$table->foreign('factId')->references('id')->on('Fact');
			$table->timestamps();
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
		Schema::drop('CompanyFact');
		Schema::drop('Fact');
	}

}
