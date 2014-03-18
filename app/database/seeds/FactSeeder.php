<?php

class FactSeeder extends Seeder {

		public function run()
		{
				DB::table('Fact')->delete();
				Fact::create(array('name' => 'Численность'));
				Fact::create(array('name' => 'Год основания'));
				Fact::create(array('name' => 'Ключевые фигуры'));

				DB::table('CompanyFact')->delete();
				CompanyFact::create(array('companyId' => '1', 'factId' => '1', 'value' => '1934'));
				CompanyFact::create(array('companyId' => '1', 'factId' => '2', 'value' => '1991'));
				CompanyFact::create(array('companyId' => '1', 'factId' => '3', 'value' => 'Дмитрий Леонидович Андрианов (генеральный директор)'));

				CompanyFact::create(array('companyId' => '2', 'factId' => '2', 'value' => '2009'));
				CompanyFact::create(array('companyId' => '2', 'factId' => '3', 'value' => 'Егор Гурьев (генеральный директор)'));

				CompanyFact::create(array('companyId' => '3', 'factId' => '2', 'value' => '2000'));
				CompanyFact::create(array('companyId' => '3', 'factId' => '3', 'value' => 'Константин Быстров (генеральный директор)'));
		}
}