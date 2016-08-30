<?php

namespace AbuLoot\Acl;

use Illuminate\Support\ServiceProvider;

class AclServiceProvider extends ServiceProvider
{
	public function boot()
	{
		$this->publishes([__DIR__ . '/../config/acl.php' => config_path('acl.php')], 'config');

		$this->publishes([__DIR__ . '/../database/migrations' => $this->app->databasePath() . '/migrations'], 'migrations');

		$this->loadViewsFrom(__DIR__ . '/../resources/views/', 'acl');

		require __DIR__ . '/Http/routes.php';
	}

	public function register()
	{
		$this->mergeConfigFrom(__DIR__ . '/../config/acl.php', 'acl');

		$this->app->bind('acl', function () {
			return new Acl;
		});
	}
}
