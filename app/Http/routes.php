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

Route::group(['prefix' => 'ws'], function() {

    Route::get('check-auth', function () {
        return response()->json([
            'auth' => \Auth::check()
        ]);
    });

    Route::get('check-sub/{channel}', function ($channel) {
        return response()->json([
            'can' => \Auth::check()
        ]);
    });
});

Route::group(['middleware' => 'auth'], function() {

    // Users
    Route::resource('profile', 'ProfileController');
    Route::resource('friends', 'FriendController');

    Route::get('my-matches', 'MatchController@myMatches');

    Route::get('all-users', 'FriendController@allUsers');
    Route::get('user-profile/{id}', 'FriendController@userProfile');
    Route::get('add-to-frieds/{id}', 'FriendController@addToFriends');
    Route::get('accept/{id}', 'FriendController@accept');

    // Match
    Route::get('create-match/{setDays?}', 'SportController@createMatch');
    Route::post('store-match', 'SportController@storeMatch');
    Route::post('join-match', 'SportController@joinMatch');
    Route::post('leave-match', 'SportController@leaveMatch');

    Route::get('sport/match/{sport_id}/{match_id}/', 'SportController@getMatch');
    Route::get('sport/match-chat/{sport_id}/{match_id}/', 'SportController@getChat');
    Route::post('chat/message/{match_id}', 'SportController@postMessage');
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
