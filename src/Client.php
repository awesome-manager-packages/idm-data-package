<?php

namespace AwesomeManager\IdmData\Client;

use Awesome\Connector\Contracts\Method;
use Awesome\Connector\Contracts\Request as RequestContract;
use AwesomeManager\IdmData\Client\Contracts\Client as ClientContract;

class Client implements ClientContract
{
    private array $config;
    
    public function __construct()
    {
        $this->config = config('idm');
    }
    
    public function login(string $username, string $password): RequestContract
    {
        return $this->makeRequest()
            ->method(Method::POST)
            ->url('token/user')
            ->formData([
                'client_id' => $this->config['client_id'],
                'client_secret' => $this->config['client_secret'],
                'username' => $username,
                'password' => $password,
            ]);
    }
    
    protected function makeRequest(): RequestContract
    {
        return new Request();
    }
}