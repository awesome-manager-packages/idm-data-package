<?php

namespace AwesomeManager\IdmData\Client;

use Awesome\Connector\Contracts\Status;
use AwesomeManager\IdmData\Client\Facades\IdmClient;
use AwesomeManager\IdmData\Client\Models\User;
use Exception;
use Illuminate\Contracts\Auth\{Authenticatable, UserProvider as ProviderContract};
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class UserProvider implements ProviderContract
{
    const SERVER_ERROR_MESSAGE = 'awesome-rest::errors.exceptions.idm_data_request_error';

    private Model $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function retrieveByToken($identifier, $token): Authenticatable|null
    {
        return null;
    }

    public function retrieveById($identifier): Authenticatable|null
    {
        return null;
    }

    public function updateRememberToken(Authenticatable $user, $token): void
    {
        //
    }

    public function retrieveByCredentials(array $credentials): Authenticatable|null
    {
        return $this->getUserByRequest(IdmClient::getUser());
    }

    public function validateCredentials(Authenticatable $user, array $credentials): bool
    {
        return false;
    }

    private function getUserByRequest(Request $request): ?Model
    {
        $response = $request->send();

        if ($response->getStatusCode() === Status::OK) {
            $data = json_decode($response->getContent(), true);

            if ($this->noError($data)) {
                return $this->hydrateUserModel($data['content'], $this->user);
            } elseif ($this->unauthorizedError($data)) {
                $this->throwException($data['content']['error_data']);
            }
        } else {
            $this->throwException($response->exception ? $response->exception->getMessage() : '');
        }

        return null;
    }

    private function noError(array $data): bool
    {
        return array_key_exists('error', $data) && $data['error'] === 0;
    }

    private function unauthorizedError(array $data): bool
    {
        return $data['content']['error_code'] !== 'user_unauthorized_exception';
    }

    private function hydrateUserModel(array $userData, Model $model = null)
    {
        if (!$model) {
            $model = new User;
        }

        return empty($userData) ? null : $model->hydrate([$userData])->first();
    }

    private function throwException(string $message): void
    {
        Log::error("Ошибка от idm-data: {$message}");
        throw new Exception(self::SERVER_ERROR_MESSAGE, Status::SERVER_ERROR);
    }
}
