<?php

class CommentSeeder extends Seeder {

		public function run()
		{
				DB::table('Comment')->delete();
				Comment::create(array('comment' => 'Новогодняя история', 'userId' => '1', 'companyId' => '1'));
				Comment::create(array('comment' => 'Комментарий', 'userId' => '1', 'companyId' => '2'));
		}
}