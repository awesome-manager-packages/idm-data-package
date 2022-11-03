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

    public function withAuthorization(string $token = null): Request
    {
        if (!$token) {
            $token = app('request')->bearerToken();
        }
        $header = config('idm.user_token_header');

        return empty($token) ? $this : $this->headers([$header => $token]);
    }
}
