<?php

namespace AwesomeManager\IdmData\Client;

use AwesomeManager\IdmData\Client\Services\TokenService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;

class ClientServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register()
    {
        $this->app->singleton(Contracts\Client::class, Client::class);
    }

    public function provides()
    {
        return [
            Contracts\Client::class,
        ];
    }
    
    public function boot()
    {
        $this->mergeConfigFrom($this->getBaseConfigPath(), 'idm');
        
        $this->app->bind(Contracts\TokenService::class, TokenService::class);
    }

    private function getBaseConfigPath()
    {
        return __DIR__ . '/../config/idm.php';
    }
}
