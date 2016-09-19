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
Route::get('sport/{sport}', ['as' => 'areas', 'uses' => 'SportController@getAreas']);
Route::get('sport/map/{sport}', 'SportController@getAreasWithMap');

Route::get('sport/{sport}/{area_id}', ['as' => 'matches', 'uses' => 'SportController@getMatches']);

Route::get('create-match', ['uses' => 'SportController@createMatch']);
Route::post('book-time', ['uses' => 'SportController@bookTime']);


// Users
Route::group(['middleware' => 'auth'], function () {

    Route::resource('profile', 'ProfileController');
    Route::resource('friend', 'FriendController');

    Route::get('all_users', 'FriendController@all_users');
    Route::get('user/{id}', 'FriendController@user');
    Route::get('add/{id}', 'FriendController@getAdd');
    Route::get('accept/{id}', 'FriendController@getAccept');
});


// Administration
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'role:root', 'role:admin']], function () {

    Route::resource('pages', 'Admin\PageController');
    Route::resource('users', 'Admin\UserController');
    Route::resource('organizations', 'Admin\OrganizationController');
    Route::resource('org_types', 'Admin\OrgTypeController');
    Route::resource('roles', 'Admin\RoleController');
    Route::resource('permissions', 'Admin\PermissionController');

    Route::resource('countries', 'Admin\CountryController');
    Route::resource('cities', 'Admin\CityController');
    Route::resource('districts', 'Admin\DistrictController');

    Route::resource('sports', 'Admin\SportController');
    Route::resource('areas', 'Admin\AreaController');
    Route::resource('fields', 'Admin\FieldController');
    Route::resource('options', 'Admin\OptionController');
    Route::resource('matches', 'Admin\MatchController');
});