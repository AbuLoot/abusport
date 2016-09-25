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
Route::get('create-match2', ['uses' => 'SportController@createMatch2']);
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

Route::get('date', function(){

    $days = [];
    $result = [];
    $month = [];

    $date_min = date("Y-m-d");
    $date_max = date("Y-m-d",strtotime($date_min." + 7 day"));
    $start = new \DateTime($date_min);
    $end = new \DateTime($date_max);   
    $interval = \DateInterval::createFromDateString("1 day");
    $period   = new \DatePeriod($start, $interval, $end);

    foreach($period as $dt)
    {
        $result["year"] = $dt->format("Y-m-d");
        $result["month"] = trans('data.month.'.$dt->format("m"));
        $result["day"] = $dt->format("d");
        $result["weekday"] = trans('data.week.'.$dt->format("w"));

        array_push($days, $result);
    }

    print_r($days);

    $date = getdate();

    echo $date['hours'] . ' - ' . $date['mday'] . ' - '.$date['wday'];
});

// Administration
Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {

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
Route::post('api/requestprofile/','ApiController@requestprofile');
Route::get('api/requestcallbacklist/{userid}','ApiController@requestcallbacklist');
Route::post('api/requestnewcallback/','ApiController@requestnewcallback');
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
