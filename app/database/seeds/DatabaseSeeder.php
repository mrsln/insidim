<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

			$this->call('CompaniesTableSeeder');
			$this->call('CharacteristicSeeder');
			$this->call('FactSeeder');
			$this->call('CommentSeeder');
	}

}