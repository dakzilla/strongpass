<?php

namespace Dakzilla\Strongpass;

use Illuminate\Support\ServiceProvider;

class StrongpassServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/package.php' => config_path('strongpass.php'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Strongpass::class, function ($app) {
            return new Strongpass(config('strongpass'));
        });

        $this->mergeConfigFrom(
            __DIR__ . '/../config/package.php', 'strongpass'
        );
    }
}
