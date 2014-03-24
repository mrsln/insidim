<?php

class UserController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if (Auth::check()) {
			$email = Auth::user()->email;
			return Response::json(array('email' => $email, 'auth' => true));
		} else {
			return Response::json(array('auth' => false));
		}
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make(Input::all(), User::$rules);
		if (!$validator->passes()) return 'false';

        // validation has passed
		$user = User::create(array(
			'email'    => Input::get('email'),
			'password' => Hash::make(Input::get('password'))
		));
		if ($user) {
			$data = array(); // массив с переменными письма
			Mail::send('emails.welcome', $data, function($message)
			{
				$message->from('podmoga@inside.im', 'Inside.im');
				$message->to(Input::get('email'))->subject('Добро пожаловать!');
			});
			Auth::attempt(array('email' => Input::get('email'), 'password' => Input::get('password')), true);
			return 'true';
		} else {
			return 'false';
		}
	}

	public function auth() {
		Auth::attempt(array('email' => Input::get('email'), 'password' => Input::get('password')), true);
		if (Auth::check()) {
			return Response::json(array('email' => Auth::user()->email, 'auth' => true));
		} else {
			return Response::json(array('auth' => false));
		}
	}

	public function logout() {
		Auth::logout();
		return 'true';
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}