<?php

namespace Derhub\IdentityAccess\Account\Services\RoleAndPermissions;

use Derhub\Shared\Message\Command\Command;

class NewRole implements Command
{
    private int $version = 1;

    public function __construct(
        private string $role,
        private array $permissions,
    ) {
    }

    public function role(): string
    {
        return $this->role;
    }

    public function permissions(): array
    {
        return $this->permissions;
    }

    public function version(): int
    {
        return $this->version;
    }
}