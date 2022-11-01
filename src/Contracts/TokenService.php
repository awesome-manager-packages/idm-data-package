<?php

namespace AwesomeManager\IdmData\Client\Contracts;

interface TokenService
{
    public function getAccessToken(): string;
}