<?php

class FactSeeder extends Seeder {

		public function run()
		{
				DB::table('CompanyFactType')->delete();
				CompanyFactType::create(array('name' => 'Численность'));
				CompanyFactType::create(array('name' => 'Год основания'));
				CompanyFactType::create(array('name' => 'Ключевые фигуры'));

				DB::table('CompanyFact')->delete();
				CompanyFact::create(array('companyId' => '1', 'companyFactTypeId' => '1', 'value' => '1934'));
				CompanyFact::create(array('companyId' => '1', 'companyFactTypeId' => '2', 'value' => '1991'));
				CompanyFact::create(array('companyId' => '1', 'companyFactTypeId' => '3', 'value' => 'Дмитрий Леонидович Андрианов (генеральный директор)'));

				CompanyFact::create(array('companyId' => '2', 'companyFactTypeId' => '2', 'value' => '2009'));
				CompanyFact::create(array('companyId' => '2', 'companyFactTypeId' => '3', 'value' => 'Егор Гурьев (генеральный директор)'));

				CompanyFact::create(array('companyId' => '3', 'companyFactTypeId' => '2', 'value' => '2000'));
				CompanyFact::create(array('companyId' => '3', 'companyFactTypeId' => '3', 'value' => 'Константин Быстров (генеральный директор)'));
		}
}