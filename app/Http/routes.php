<?php

// Route::auth();

// Authentication routes...
Route::get('login', 'Auth\AuthController@getLogin');
Route::post('login', 'Auth\AuthCustomController@postLogin');
Route::get('logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('register', 'Auth\AuthController@getRegister');
Route::post('register', 'Auth\AuthCustomController@postRegister');
Route::get('confirm/{token}', 'Auth\AuthCustomController@confirm');

// Repeat confirm
Route::get('repeat_confirm', 'Auth\AuthCustomController@getRepeat');
Route::post('repeat_confirm', 'Auth\AuthCustomController@postRepeat');

// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');

// Confirmation of registration
Route::get('confirm-register', 'Auth\AuthCustomController@getConfirmRegister');
Route::post('confirm-register', 'Auth\AuthCustomController@postConfirmRegister');

// Board
Route::get('/', ['as' => 'index', 'uses' => 'SportController@getSports']);
Route::get('areas', ['as' => 'areas', 'uses' => 'AreaController@getAreas']);

// Test
Route::get('/home', 'HomeController@index');

Route::get('add-sports', function() {

	$sport = new App\Sport;

	$faker = Faker\Factory::create('ru_RU');

	for ($i=0; $i < 30; $i++) { 
		echo $faker->name . '<br>';
		echo $faker->phoneNumber . '<br>';
		echo $faker->address . '<hr>';
	} 

});
