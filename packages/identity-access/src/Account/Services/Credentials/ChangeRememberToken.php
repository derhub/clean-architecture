<?php

namespace Derhub\IdentityAccess\Account\Services\Credentials;

use Derhub\Shared\Message\Command\Command;

class ChangeRememberToken implements Command
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