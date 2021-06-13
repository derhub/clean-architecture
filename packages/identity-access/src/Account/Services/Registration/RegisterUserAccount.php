<?php

namespace Derhub\IdentityAccess\Account\Services\Registration;

use Derhub\Shared\Message\Command\Command;

class RegisterUserAccount implements Command
{
    private int $version = 1;

    public function __construct(
        private string $username,
        private string $password,
        private string $email,
    ) {
    }

    public function username(): string
    {
        return $this->username;
    }

    public function password(): string
    {
        return $this->password;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function version(): int
    {
        return $this->version;
    }
}