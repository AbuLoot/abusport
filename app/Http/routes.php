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

Route::get('confirm-register', ['as' => 'confirm.register', 'uses' => 'Auth\AuthController@confirmRegister']);

Route::group(['middleware' => 'web'], function () {

	Route::get('/', ['as' => 'index', 'uses' => 'SportController@getSports']);
	Route::get('areas', ['as' => 'areas', 'uses' => 'AreaController@getAreas']);

});

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


Route::get('test', function() {
	$var = 'ABCDEFGH:/MNRPQR/';
	echo "Оригинал: $var<hr />\n";

	/* Обе следующих строки заменяют всю строку $var на 'bob'. */
	echo substr_replace($var, 'bob', 0) . "<br />\n";
	echo substr_replace($var, 'bob', 0, strlen($var)) . "<br />\n";

	/* Вставляет 'bob' в начало $var. */
	echo substr_replace($var, 'bob', 0, 1) . "<br />\n";

	/* Обе следующих строки заменяют 'MNRPQR' in $var на 'bob'. */
	echo substr_replace($var, 'bob', 10, -1) . "<br />\n";
	echo substr_replace($var, 'bob', -7, -1) . "<br />\n";

	/* Удаляет 'MNRPQR' из $var. */
	echo substr_replace($var, '', 10, -1) . "<br />\n";
});