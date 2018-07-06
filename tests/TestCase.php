<?php

namespace Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return ['Signhost\SignhostServiceProvider'];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default
        $app['config']->set('signhost', [
            'appname' => env('SIGNHOST_APPNAME'),
            'appkey'  => env('SIGNHOST_APPKEY'),
            'apikey'  => env('SIGNHOST_APIKEY'),
            'sharedsecret'  => env('SIGNHOST_SHAREDSECRET'),
            'environment'  => env('SIGNHOST_ENVIRONMENT'),
        ]);

    }
}
