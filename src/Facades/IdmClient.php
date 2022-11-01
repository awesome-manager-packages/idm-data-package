<?php

namespace AwesomeManager\IdmData\Client\Facades;

use Awesome\Connector\Contracts\Request;
use AwesomeManager\IdmData\Client\Contracts\Client as ClientContract;
use Illuminate\Support\Facades\Facade;

/**
 * @method static Request login(string $username, string $password)
 */
class IdmClient extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ClientContract::class;
    }
}
