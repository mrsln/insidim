<?php

	class CompanyFact extends Eloquent
	{
		protected $table = 'CompanyFact';
		protected $fillable = array('value', 'companyId', 'factId');

	}