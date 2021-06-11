<?php

namespace Derhub\IdentityAccess\Account\Infrastructure;

interface RoleRepository
{
    public function all(): array;
    
    public function newRole(string $role, array $permissions): bool;

    public function removeRole(string $role): bool;

    public function givePermissions(string $role, array $permissions): bool;

    public function removePermissions(string $role, array $permissions): bool;
}