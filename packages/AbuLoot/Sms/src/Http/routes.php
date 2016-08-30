<?php

Route::group(['prefix' => 'sms', 'namespace' => 'AbuLoot\Sms\Http\Controllers'], function () {

	Route::get('/', ['as' => 'sms.index', 'uses' => 'SmsController@index']);
	Route::get('send/{phone}/{name}', ['as' => 'sms.send', 'uses' => 'SmsController@sendSms']);

});