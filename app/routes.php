<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

App::missing(function($exception)
{
    return Response::view('error', array(), 404);
});

Route::get('/', function()
{
	return View::make('index');
});

Route::group(array('prefix' => 'api/'), function()
{
	Route::post('company/addComment', array('before' => 'auth', 'uses' => 'CompanyController@addComment'));
	Route::post('company/addFact', array('before' => 'auth', 'uses' => 'CompanyController@addFact'));
	Route::post('company/addTag', 'CompanyController@addTag');
	Route::post('company/vote', 'CompanyController@vote');
	Route::resource('company', 'CompanyController');
	Route::post('user/auth', 'UserController@auth');
	Route::get('user/logout', 'UserController@logout');
	Route::resource('user', 'UserController');
});