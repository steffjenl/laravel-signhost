<?php

namespace Signhost;

/**
 * Class SignhostServiceProvider
 *
 * @package   laravel-signhost
 * @author    Stephan Eizinga <stephan.eizinga@gmail.com>
 */
class SignhostServiceProvider extends \Illuminate\Support\ServiceProvider
{

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes(
            [
            __DIR__.'/../../config/signhost.php' => config_path('signhost.php'),
        ]
        );

        if ($this->app->runningInConsole()) {
            $this->commands([]);
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/signhost.php',
            'signhost'
        );

        $this->app->singleton(Signhost::class, function ($app) {
            return new Signhost(config('signhost.appname'), config('signhost.appkey'),config('signhost.apikey'),config('signhost.sharedsecret'),config('signhost.environment'));
        }
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            Signhost::class
        ];
    }
}
