<?php

	class Company extends Eloquent
	{
		protected $table = 'Company';

		public function companyCharacteristic() {
			return $this->hasMany('CompanyCharacteristic', 'companyId');
		}
	}