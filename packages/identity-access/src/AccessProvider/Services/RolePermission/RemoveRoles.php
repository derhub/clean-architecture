<?php

namespace Derhub\IdentityAccess\AccessProvider\Services\RolePermission;

use Derhub\Shared\Message\Query\Query;

class RemoveRoles implements Query
{
    private int $version = 1;

    public function __construct(
        private array|string $roles,
    ) {
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