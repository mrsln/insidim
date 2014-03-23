<?php

	class Comment extends Eloquent
	{
		protected $table = 'Comment';
		protected $fillable = array('comment', 'userId', 'companyId');
	}