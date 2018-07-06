<?php

namespace Tests;

use Signhost\SignhostFacade;
use Signhost\SignhostServiceProvider;
use Signhost\Signhost;
use Mockery;

class ServiceProviderTest extends TestCase
{
    /**
     * Load package service provider
     * @param  \Illuminate\Foundation\Application $app
     * @return SignhostServiceProvider
     */
    protected function getPackageProviders($app)
    {
        return [SignhostServiceProvider::class];
    }
    /**
     * Load package alias
     * @param  \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'Signhost' => SignhostFacade::class,
        ];
    }

    /** @test */
    public function can_connect_to_kemp_loadmaster()
    {
        $config = $this->app['config'];
        $client = new Signhost($config->get('signhost.appname'), $config->get('signhost.appkey'),$config->get('signhost.apikey'),$config->get('signhost.sharedsecret'),$config->get('signhost.environment'));
    }
}
