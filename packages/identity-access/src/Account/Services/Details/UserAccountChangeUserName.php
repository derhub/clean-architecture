<?php

namespace Derhub\IdentityAccess\Account\Services\Details;

use Derhub\Shared\Message\Command\Command;

class UserAccountChangeUserName implements Command
{
    private int $version = 1;

    public function __construct(
        private string $userId,
        private string $username,
    ) {
    }

    public function userId(): string
    {
        return $this->userId;
    }

    public function username(): string
    {
        return $this->username;
    }

    public function version(): int
    {
        return $this->version;
    }
}