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
Route::get('/', 'SportController@getSports');
Route::get('sport/{sport}', 'SportController@getAreas');
Route::get('sport/map/{sport}', 'SportController@getAreasWithMap');
Route::get('sport/calendar/{sport}/{area_id}/{setDays?}', 'SportController@getMatchesWithCalendar');

Route::group(['middleware' => 'auth'], function() {

    // Users
    Route::resource('profile', 'ProfileController');
    Route::resource('friends', 'FriendController');

    Route::get('all-users', 'FriendController@allUsers');
    Route::get('user-profile/{id}', 'FriendController@userProfile');
    Route::get('add-to-frieds/{id}', 'FriendController@addToFriends');
    Route::get('accept/{id}', 'FriendController@accept');
    Route::get('my-matches', 'FriendController@accept');

    // Match
    Route::get('create-match/{setDays?}', 'SportController@createMatch');
    Route::post('store-match', 'SportController@storeMatch');
    Route::post('join-match', 'SportController@joinMatch');
    Route::post('left-match', 'SportController@leftMatch');

    Route::get('sport/match/{sport}/{match_id}/', 'SportController@getMatch');

});

Route::get('sport/{sport}/{area_id}/{date?}', 'SportController@getMatches');


// Administration
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'role:root', 'role:admin']], function () {

    Route::get('/', 'Admin\AdminController@index');
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
    Route::resource('schedules', 'Admin\ScheduleController');
    Route::resource('options', 'Admin\OptionController');
    Route::resource('matches', 'Admin\MatchController');
});


// Api
Route::get('api/requestlogin/{phone}/{password}','ApiController@requestlogin');
Route::get('api/requestsms/{mobile}/{name}/{surname}/{email}/{password}/{sex}','ApiController@requestsms');

Route::get('api/requestverifyotp/{otp}','ApiController@requestverifyotp');
Route::get('api/requestsports','ApiController@requestsports');
Route::get('api/requestplaygrounds/{sportid}','ApiController@requestplaygrounds');	
Route::get('api/requestmatches/{areaid}','ApiController@requestmatches');
Route::get('api/requestmatchplayers/{matchid}','ApiController@requestmatchplayers');
Route::get('api/requestjoinmatch/{matchid}/{userid}','ApiController@requestjoinmatch');
Route::get('api/requestexitmatch/{matchid}/{userid}','ApiController@requestexitmatch');
Route::get('api/requestweekdays/{playgroundid}/{selecteddate}','ApiController@requestweekdays');
Route::get('api/requestmatchcreate/{userid}/{fieldid}/{starttime}/{endtime}/{date}/{matchtype}/{gametype}/{numberofplayers}/{format}/{price}/{description}/{playgroundid}','ApiController@requestmatchcreate');
