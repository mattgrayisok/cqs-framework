<?php
/**
 * User: Slice
 * Date: 07/11/15
 * Time: 21:49
 */

namespace App\Util\Profiling;


use Illuminate\Support\ServiceProvider;

class TimingLoggerServiceProvider extends ServiceProvider{

	public function register()
	{
		$this->app->singleton('App\Util\Profiling\TimingLoggerContract', function ($app) {
			return new FileTimingLogger();
		});
	}

}