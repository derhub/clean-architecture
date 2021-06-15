<?php

namespace Derhub\IdentityAccess\AccessProvider\Services\UserRoles;

use Derhub\Shared\Message\Command\Command;

class UpdateUserRoles implements Command
{
    private int $version = 1;

    public function __construct(
        private string $userId,
        private array|string $roles
    ) {
    }

    public function userId(): string
    {
        return $this->userId;
    }

    public function roles(): array|string
    {
        return $this->roles;
    }

    public function version(): int
    {
        return $this->version;
    }
}