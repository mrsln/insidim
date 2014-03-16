<?php

	class Characteristic extends Eloquent
	{
		protected $table = 'Characteristic';
		protected $fillable = array('name', 'count');

		function companyCharacteristic() {
			return $this->hasOne('CompanyCharacteristic', 'characteristicId');
		}

		public function scopeOfName($query, $name) {
			return $query->whereName($name);
		}
	}