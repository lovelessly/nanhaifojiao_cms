<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');

//Route::get('/home/test', 'HomeController@test');
//Route::controller('home', 'HomeController');
//Route::controller('auth', 'Auth\AuthController');

Route::controllers([
	'admin' => 'AdminController',
	'api' => 'ApiController',
	'file' => 'FileController',
]);
