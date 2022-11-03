<?php

namespace AwesomeManager\IdmData\Client\Contracts;

use Awesome\Connector\Contracts\Request as RequestContract;

interface Client
{
    public function login(string $username, string $password): RequestContract;

    public function getUser(string $token = null): RequestContract;
}