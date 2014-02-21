<?php

class CompaniesTableSeeder extends Seeder {

		public function run()
		{
				DB::table('companies')->delete();
				Company::create(array('name' => 'Prognoz'));
				Company::create(array('name' => 'Enaza'));
				Company::create(array('name' => 'DataKit'));
		}
}