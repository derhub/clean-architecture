<?php

namespace Derhub\IdentityAccess\Account\Services\Details;

use Derhub\Shared\Message\Command\Command;

class UserAccountChangePassword implements Command
{
    private int $version = 1;

    public function __construct(
        private string $userId,
        private string $password,
    ) {
    }

    public function userId(): string
    {
        return $this->userId;
    }

    public function password(): string
    {
        return $this->password;
    }

    public function version(): int
    {
        return $this->version;
    }
}