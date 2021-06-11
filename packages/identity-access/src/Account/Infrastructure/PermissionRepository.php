<?php

namespace Derhub\IdentityAccess\Account\Infrastructure;

interface PermissionRepository
{
    public function all(): array;

    public function exists(string $permission): bool;
}