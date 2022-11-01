<?php

namespace AwesomeManager\IdmData\Client;

use Awesome\Connector\Contracts\Request as RequestContract;
use AwesomeManager\IdmData\Client\Contracts\Client as ClientContract;

class Client implements ClientContract
{
    protected function makeRequest(): RequestContract
    {
        return new Request();
    }
}