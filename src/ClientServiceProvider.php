<?php

namespace AwesomeManager\IdmData\Client;

use AwesomeManager\IdmData\Client\Guards\TokenGuard;
use AwesomeManager\IdmData\Client\Services\TokenService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class ClientServiceProvider extends ServiceProvider
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

        Auth::extend('idm', function ($app, $name, array $config) {
            $userProvider = app(UserProvider::class);
            $request = app('request');

            return new TokenGuard($userProvider, $request, $config);
        });
    }

    private function getBaseConfigPath()
    {
        return __DIR__ . '/../config/idm.php';
    }
}
