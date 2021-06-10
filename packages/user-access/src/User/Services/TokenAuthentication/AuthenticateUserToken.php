<?php

namespace Derhub\UserAccess\User\Services\TokenAuthentication;

use Derhub\Shared\Message\Command\Command;

class AuthenticateUserToken implements Command
{
    private int $version = 1;

    public function __construct(
        private string $userId,
        private string $token,
    ) {
    }

    public function userId(): string
    {
        return $this->userId;
    }

    public function token(): string
    {
        return $this->token;
    }

    public function version(): int
    {
        return $this->version;
    }
}