<?php

namespace Derhub\IdentityAccess\Account\Services\RoleAndPermissions;

use Derhub\Shared\Message\Command\Command;

class RemoveRole implements Command
{
    private int $version = 1;

    public function __construct(
        private string $role,
    ) {
    }

    public function role(): string
    {
        return $this->role;
    }

    public function version(): int
    {
        return $this->version;
    }
}