<?php

namespace AwesomeManager\IdmData\Client\Services;

use Awesome\Connector\Contracts\{Method, Request as RequestContract, Status};
use Awesome\Connector\Exceptions\ConnectorException;
use Awesome\Connector\Facades\Connector;
use AwesomeManager\IdmData\Client\Contracts\TokenService as ServiceContract;
use AwesomeManager\IdmData\Client\Request;
use Illuminate\Http\Response;

class TokenService implements ServiceContract
{
    public function getAccessToken(): string
    {
        if (!$token = $this->makeToken()) {
            throw new ConnectorException('Access token receiving error');
        }

        return $token->access_token;
    }

    private function makeToken(): ?object
    {
        $response = $this->sendRequest($this->makeRequest());

        if ($response->getStatusCode() === Status::OK) {
            return json_decode($response->getContent());
        }

        return null;
    }

    private function sendRequest(RequestContract $request): Response
    {
        return Connector::send($request);
    }

    private function makeRequest(): RequestContract
    {
        $config = config('idm');

        return (new Request())
            ->method(Method::POST)
            ->url('token/client')
            ->formData([
                'client_id' => $config['client_id'],
                'client_secret' => $config['client_secret']
            ]);
    }
}
