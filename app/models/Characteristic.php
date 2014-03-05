<?php

	class Characteristic extends Eloquent
	{
		protected $table = 'Characteristic';

		function companyCharacteristic() {
			return $this->hasOne('CompanyCharacteristic', 'characteristicId');
		}
	}