<?php

	class Company extends Eloquent
	{
		protected $table = 'Company';

		public function characteristic() {
			return $this->hasManyThrough('Characteristic', 'CompanyCharacteristic', 'characteristicId', 'id');
		}
	}