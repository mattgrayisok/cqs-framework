<?php namespace App\Providers;

use Illuminate\Bus\Dispatcher;
use Illuminate\Support\ServiceProvider;

class BusServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @param  \Illuminate\Bus\Dispatcher  $dispatcher
     * @return void
     */
    public function boot(Dispatcher $dispatcher)
    {
        $dispatcher->mapUsing(function($command)
        {

			if( substr( get_class($command), -5 ) == 'Query' ){

				return Dispatcher::simpleMapping(
					$command, 'App\Jobs\Queries', 'App\Handlers\Queries'
				);

			}

            return Dispatcher::simpleMapping(
                $command, 'App\Jobs\Commands', 'App\Handlers\Commands'
            );
        });

        $dispatcher->pipeThrough([
									'App\Pipes\LogTiming',
                                    'App\Pipes\AuthGate',
                                    'App\Pipes\ValidationGate',
                                    'App\Pipes\UseDatabaseTransactions',
                                    'App\Pipes\LogCommand',
									'App\Pipes\CacheQuery',
		]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

}