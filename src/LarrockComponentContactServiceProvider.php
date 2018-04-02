<?php

namespace Larrock\ComponentContact;

use Illuminate\Support\ServiceProvider;
use Larrock\ComponentContact\Middleware\ContactCreateTemplate;

class LarrockComponentContactServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->loadViewsFrom(__DIR__.'/../views', 'larrock');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->publishes([
            __DIR__.'/../views' => base_path('resources/views/vendor/larrock'),
        ], 'views');
    }

    /**
     * Register the application services.
     * @return void
     */
    public function register()
    {
        $this->app['router']->aliasMiddleware('ContactCreateTemplate', ContactCreateTemplate::class);

        $this->app->singleton('larrockcontact', function () {
            $class = config('larrock.components.contact', ContactComponent::class);

            return new $class;
        });
    }
}
