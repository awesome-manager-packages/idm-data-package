<?php

namespace AwesomeManager\IdmData\Client\Facades;

use Awesome\Connector\Contracts\Request;
use AwesomeManager\IdmData\Client\Contracts\Client as ClientContract;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Facade;

/**
 * @method static Request login(string $username, string $password)
 * @method static Request logout()
 * @method static Request refreshAccessToken(string $refreshToken)
 * @method static Request getUser(string $token = null)
 * @method static Request updateUser(string $userId, array $userInfo)
 * @method static Request createUserImage(string $userId, UploadedFile $file)
 * @method static Request deleteUserImage(string $userId)
 */
class IdmClient extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ClientContract::class;
    }
}
