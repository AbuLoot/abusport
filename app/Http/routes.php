<?php

// Authentication routes...
Route::get('login', 'Auth\AuthController@getLogin');
Route::post('login', 'Auth\AuthCustomController@postLogin');
Route::get('logout', 'Auth\AuthCustomController@getLogout');

// Registration routes...
Route::get('register', 'Auth\AuthController@getRegister');
Route::post('register', 'Auth\AuthCustomController@postRegister');
// Route::get('confirm/{token}', 'Auth\AuthCustomController@confirm');

// Confirmation of registration
Route::get('confirm-register', 'Auth\AuthCustomController@getConfirmRegister');
Route::post('confirm-register', 'Auth\AuthCustomController@postConfirmRegister');

// Password reset link request routes...
// Route::get('password/email', 'Auth\PasswordController@getEmail');
// Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
// Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
// Route::post('password/reset', 'Auth\PasswordController@postReset');


// Board
Route::get('/', ['as' => 'index', 'uses' => 'SportController@getSports']);
Route::get('areas', ['as' => 'areas', 'uses' => 'AreaController@getAreas']);


// Administration
Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {

	Route::resource('pages', 'Admin\PageController');
    Route::resource('users', 'Admin\UserController');
    Route::resource('organizations', 'Admin\OrganizationController');
    Route::resource('org_types', 'Admin\OrgTypeController');

    Route::resource('countries', 'Admin\CountryController');
    Route::resource('cities', 'Admin\CityController');
    Route::resource('districts', 'Admin\DistrictController');

    Route::resource('sports', 'Admin\SportController');
    Route::resource('areas', 'Admin\AreaController');
    Route::resource('fields', 'Admin\FieldController');
    Route::resource('options', 'Admin\OptionController');
    Route::resource('matches', 'Admin\MatchController');
});

Route::get('add-data', function() {

	// for ($i=0; $i < 30; $i++) { 
	// 	echo $faker->name . '<br>';
	// 	echo $faker->phoneNumber . '<br>';
	// 	echo $faker->address . '<hr>';
	// } 

});
