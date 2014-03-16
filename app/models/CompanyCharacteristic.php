<?php

	class CompanyCharacteristic extends Eloquent
	{
		protected $fillable = array('characteristicId', 'companyId', 'count');
		protected $table = 'CompanyCharacteristic';
	}