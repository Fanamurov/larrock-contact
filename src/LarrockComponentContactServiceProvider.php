<?php

namespace Larrock\ComponentContact;

use Illuminate\Support\ServiceProvider;
use Larrock\ComponentContact\Middleware\ContactCreateTemplate;

class LarrockComponentContactServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->loadViewsFrom(__DIR__.'/views', 'larrock');
        $this->loadTranslationsFrom(__DIR__.'/lang', 'larrock');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        $this->publishes([
            __DIR__.'/lang' => resource_path('lang/vendor/larrock')
        ], 'lang');

        $this->publishes([
            __DIR__.'/views' => base_path('resources/views/vendor/larrock')
        ], 'views');

        $this->publishes([
            __DIR__.'/config/larrock-form.php' => config_path('larrock-form.php')
        ], 'config');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom( __DIR__.'/config/larrock-form.php', 'larrock-form');

        $this->app['router']->aliasMiddleware('ContactCreateTemplate', ContactCreateTemplate::class);

        $this->app->singleton('larrockcontact', function() {
            $class = config('larrock.components.contact', ContactComponent::class);
            return new $class;
        });
    }
}
