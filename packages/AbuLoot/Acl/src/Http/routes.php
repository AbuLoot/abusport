<?php

Route::group(['namespace' => 'AbuLoot\Acl\Http\Controllers'], function () {
	Route::resource('acl', 'AclController', [
			'except' => ['show']
		]
	);
});