<?php

namespace Derhub\IdentityAccess\AccessProvider\Services\RolePermission;

use Derhub\Shared\Message\Command\Command;

class CreateRoleAndPermissions implements Command
{
    private int $version = 1;

    public function __construct(
        private string $role,
        private array|string $permissions
    ) {
    }

    public function role(): string
    {
        return $this->role;
    }

    public function permissions(): array|string
    {
        return $this->permissions;
    }

    public function version(): int
    {
        return $this->version;
    }
}