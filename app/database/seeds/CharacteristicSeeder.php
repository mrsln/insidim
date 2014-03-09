<?php

class CharacteristicSeeder extends Seeder {

		public function run()
		{
			DB::table('User')->delete();
			User::create(array(
				'email'    => 'atn@marsel.name',
				'password' => Hash::make('awesome')
			));
			User::create(array(
				'email'    => 'charjob@gmail.com',
				'password' => Hash::make('awesome1')
			));

			DB::table('Characteristic')->delete();
			Characteristic::create(array('name' => 'белая зарплата', 'count' => 1));
			Characteristic::create(array('name' => 'бесплатные печеньки', 'count' => 1));
			Characteristic::create(array('name' => 'свободный график', 'count' => 1));

			DB::table('CompanyCharacteristic')->delete();
			CompanyCharacteristic::create(array('characteristicId' => 1, 'companyId' => 1, 'count' => 1));
			CompanyCharacteristic::create(array('characteristicId' => 2, 'companyId' => 2, 'count' => 1));
			CompanyCharacteristic::create(array('characteristicId' => 3, 'companyId' => 1, 'count' => 2));

			DB::table('UserVote')->delete();
			UserVote::create(array('userId' => 1, 'companyCharacteristicId' => 1));
			UserVote::create(array('userId' => 1, 'companyCharacteristicId' => 2));
			UserVote::create(array('userId' => 1, 'companyCharacteristicId' => 3));
			UserVote::create(array('userId' => 2, 'companyCharacteristicId' => 3));
		}
}
