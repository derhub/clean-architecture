<?php

namespace Derhub\IdentityAccess\AccessProvider\Infrastructure\Database\Doctrine;

use Derhub\IdentityAccess\AccessProvider\Model\RoleAndPermissionsRepository;

final class DoctrineDbalRoleAndPermissionsRepository implements RoleAndPermissionsRepository
{

    public function getPermissions(array $roles): array
    {
        // TODO: Implement getPermissions() method.
    }

    public function getUniquePermissions(array $roles): array
    {
        // TODO: Implement getUniquePermissions() method.
    }

    public function all(): array
    {
        // TODO: Implement all() method.
    }

    public function removeRoles(array|string $roles): void
    {
        // TODO: Implement removeRoles() method.
    }

    public function createRole(string $role, array|string $permissions)
    {
        // TODO: Implement createRole() method.
    }

    public function updateRole(string $role, array|string $permissions)
    {
        // TODO: Implement updateRole() method.
    }
}
