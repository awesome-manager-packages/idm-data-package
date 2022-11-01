<?php

namespace AwesomeManager\IdmData\Client;

use AwesomeManager\IdmData\Client\Middleware\AuthMiddleware;
use Awesome\Connector\Facades\Connector;
use Awesome\Connector\Request as BaseRequest;
use Illuminate\Http\Response;

class Request extends BaseRequest
{
    public function send(): Response
    {
        return Connector::withMiddleware(AuthMiddleware::class)->send($this);
    }
}