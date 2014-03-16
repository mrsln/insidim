<?php

	class Company extends Eloquent
	{
		protected $table = 'Company';
		protected $fillable = array('name');

		public function characteristic() {
			return $this->hasManyThrough('CompanyCharacteristic', 'Characteristic', 'id', 'companyId');
		}
	}