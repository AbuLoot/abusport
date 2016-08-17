<?php

Route::group(['middleware' => 'web'], function () {

	Route::get('/', ['as' => 'index', 'uses' => 'SportController@getSports']);
	Route::get('areas', ['as' => 'areas', 'uses' => 'AreaController@getAreas']);

});

Route::get('add-sports', function() {

	$sport = new App\Sport;

	$faker = Faker\Factory::create('ru_RU');

	for ($i=0; $i < 30; $i++) { 
		echo $faker->name . '<br>';
		echo $faker->phoneNumber . '<br>';
		echo $faker->address . '<hr>';
	} 

});


Route::auth();

Route::get('/home', 'HomeController@index');
