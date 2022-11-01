<?php

namespace AwesomeManager\IdmData\Client\Middleware;

use Awesome\Connector\Middleware\RequestMiddleware;
use AwesomeManager\IdmData\Client\Contracts\TokenService;
use Closure;
use Psr\Http\Message\RequestInterface;

class AuthMiddleware extends RequestMiddleware
{
    public function handle(): Closure
    {
        return function (RequestInterface $request) {
            return $this->authenticate($request, app(TokenService::class)->getAccessToken());
        };
    }

    private function authenticate(RequestInterface $request, string $accessToken): RequestInterface
    {
        return $request->withHeader('Authorization', "Bearer {$accessToken}");
    }
}
