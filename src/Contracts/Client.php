<?php

namespace AwesomeManager\IdmData\Client\Contracts;

use Awesome\Connector\Contracts\Request as RequestContract;
use Illuminate\Http\UploadedFile;

interface Client
{
    public function login(string $username, string $password): RequestContract;

    public function logout(): RequestContract;

    public function refreshAccessToken(string $refreshToken): RequestContract;

    public function getUser(string $token = null): RequestContract;

    public function updateUser(string $userId, array $userInfo): RequestContract;

    public function createUserImage(string $userId, UploadedFile $file): RequestContract;

    public function deleteUserImage(string $userId): RequestContract;
}