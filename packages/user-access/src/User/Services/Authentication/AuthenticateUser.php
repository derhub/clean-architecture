<?php

namespace Derhub\UserAccess\User\Services\Authentication;

use Derhub\Shared\Message\Command\Command;

class AuthenticateUser implements Command
{
    private int $version = 1;

    public function __construct(
        private string $username,
        private string $password,
    )
    {
    }

    public function username(): string
    {
        return $this->username;
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