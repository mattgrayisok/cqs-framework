<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ActingServiceProvider extends ServiceProvider {

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        \App::singleton('actingModel', function()
        {
            return new \App\Facades\ActingModel();
        });
    }

}