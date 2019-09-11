<?php

namespace Signhost;

/**
 * Class SignhostServiceProvider
 *
 * @package   laravel-signhost
 * @author    Stephan Eizinga <stephan@monkeysoft.nl>
 */
class SignhostServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public $defer = true;

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes(
            [
            __DIR__.'/../config/signhost.php' => config_path('signhost.php'),
        ]
        );

        if ($this->app->runningInConsole()) {
            $this->commands([]);
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/signhost.php',
            'signhost'
        );

        $this->app->bind(
            SignhostClient::class,
            static function () {
                return new SignhostClient(
                    config('signhost.appname'),
                    config('signhost.appkey'),
                    config('signhost.apikey'),
                    [
                        //SignhostClient::OPT_URL => 'https://url.to.use/instead-of.default',
                        SignhostClient::OPT_TIMEOUT => config('signhost.requestTimeout'),
                        //Signhostclient::OPT_CAINFOPATH => '/path/to/cainfo'
                    ]
                );
            }
        );
        $this->app->bind(
            Signhost::class,
            static function ($app) {
                return new Signhost(
                    $app->make(SignhostClient::class),
                    config('signhost.returnArray', false)
                );
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
