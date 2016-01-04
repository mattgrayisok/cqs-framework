<?php
/**
 * User: Slice
 * Date: 07/11/15
 * Time: 16:37
 */

namespace App\Util\CommandLogger;


use Illuminate\Support\ServiceProvider;

class CommandLoggerServiceProvider extends ServiceProvider{

	public function register()
	{
		$this->app->singleton('App\Util\CommandLogger\CommandLoggerContract', function ($app) {
			return new FileCommandLogger();
		});
	}

}