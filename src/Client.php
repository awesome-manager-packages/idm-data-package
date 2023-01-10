<?php

namespace AwesomeManager\IdmData\Client;

use Awesome\Connector\Contracts\Method;
use Awesome\Connector\Contracts\Request as RequestContract;
use AwesomeManager\IdmData\Client\Contracts\Client as ClientContract;
use Illuminate\Http\UploadedFile;

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

    public function logout(): RequestContract
    {
        return $this->makeRequest()
            ->method(Method::DELETE)
            ->url('token/user')
            ->withAuthorization();
    }

    public function refreshAccessToken(string $refreshToken): RequestContract
    {
        return $this->makeRequest()
            ->method(Method::POST)
            ->url('token/refresh')
            ->formData([
                'client_id' => $this->config['client_id'],
                'client_secret' => $this->config['client_secret'],
                'refresh_token' => $refreshToken,
            ]);
    }

    public function getUser(string $token = null): RequestContract
    {
        return $this->makeRequest()
            ->url('user')
            ->withAuthorization($token);
    }

    public function updateUser(string $userId, array $userInfo): RequestContract
    {
        return $this->makeRequest()
            ->method(Method::POST)
            ->url("user/{$userId}")
            ->formData($userInfo)
            ->withAuthorization();
    }

    public function createUserImage(string $userId, UploadedFile $file): RequestContract
    {
        return $this->makeRequest()
            ->method(Method::POST)
            ->url("user/{$userId}/image")
            ->formData([
                'image' => $file
            ])
            ->withAuthorization();
    }

    public function deleteUserImage(string $userId): RequestContract
    {
        return $this->makeRequest()
            ->method(Method::DELETE)
            ->url("user/{$userId}/image")
            ->withAuthorization();
    }

    protected function makeRequest(): RequestContract
    {
        return new Request();
    }
}
