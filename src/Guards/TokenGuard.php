<?php

namespace AwesomeManager\IdmData\Client\Guards;

use Illuminate\Http\Request;
use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;

class TokenGuard implements Guard
{
    use GuardHelpers;

    private $request;

    public function __construct(UserProvider $provider, Request $request, $configuration)
    {
        $this->provider = $provider;
        $this->request = $request;
    }

    public function user()
    {
        if (! is_null($this->user)) {
            return $this->user;
        }

        $user = null;

        if (! empty($this->request->bearerToken())) {
            $user = $this->provider->retrieveByCredentials([]);
        }

        return $this->user = $user;
    }

    public function validate(array $credentials = [])
    {
        if (empty($credentials[$this->inputKey])) {
            return false;
        }

        $credentials = [$this->storageKey => $credentials[$this->inputKey]];

        if ($this->provider->retrieveByCredentials($credentials)) {
            return true;
        }

        return false;
    }
}
