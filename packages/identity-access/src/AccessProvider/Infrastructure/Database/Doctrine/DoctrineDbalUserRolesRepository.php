<?php

namespace Derhub\IdentityAccess\AccessProvider\Infrastructure\Database\Doctrine;

use Derhub\IdentityAccess\AccessProvider\Model\UserRolesRepository;

final class DoctrineDbalUserRolesRepository implements UserRolesRepository
{
    public function getRoles(string $user): array
    {
        // TODO: Implement getRoles() method.
    }

    public function hasRoles(string $user, array|string $roles): bool
    {
        // TODO: Implement hasRoles() method.
    }

    public function assignRoles(string $user, array|string $roles): bool
    {
        // TODO: Implement assignRoles() method.
    }

    public function removeRoles(string $user, array|string $roles): bool
    {
        // TODO: Implement removeRoles() method.
    }
}