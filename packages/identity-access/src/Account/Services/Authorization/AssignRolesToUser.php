<?php

namespace Derhub\IdentityAccess\Account\Services\Authorization;

use Derhub\Shared\Message\Command\Command;

class AssignRolesToUser implements Command
{
    private int $version = 1;

    public function __construct(
        private string $userId,
        private array $roles,
    ) {
    }

    public function userId(): string
    {
        return $this->userId;
    }

    public function version(): int
    {
        return $this->version;
    }

    public function roles(): array
    {
        return $this->roles;
    }
}