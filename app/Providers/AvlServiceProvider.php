<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AvlServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

        $this->loadHelpers();
    }


    /**
     * Load helpers.
     */
    protected function loadHelpers()
    {
        foreach (glob(app_path('/Helpers/*.php')) as $filename) {
            require_once $filename;
        }
    }
}
