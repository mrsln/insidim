<?php

class CharacteristicSeeder extends Seeder {

		public function run()
		{
			DB::table('User')->delete();
			User::create(array(
				'email'    => 'atn@marsel.name',
				'password' => Hash::make('awesome')
			));

			DB::table('Characteristic')->delete();
			Characteristic::create(array('name' => 'белая зарплата'));
			Characteristic::create(array('name' => 'бесплатные печеньки'));

			DB::table('CompanyCharacteristic')->delete();
			CompanyCharacteristic::create(array('characteristicId' => 1, 'companyId' => 1, 'count' => 1));
			CompanyCharacteristic::create(array('characteristicId' => 2, 'companyId' => 2, 'count' => 1));

			DB::table('UserVote')->delete();
			UserVote::create(array('userId' => 1, 'companyCharacteristicId' => 1));
			UserVote::create(array('userId' => 1, 'companyCharacteristicId' => 2));
		}
}