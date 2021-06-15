<?php

namespace Derhub\IdentityAccess\AccessProvider\Model;

use Derhub\IdentityAccess\AccessProvider\Services\RoleManager;

interface RoleAndPermissionsRepository
{
    /**
     * Return list of role permission
     * format: [['role' => string, 'permission' => string]]
     * @param array $roles
     * @return array
     */
    public function getPermissions(array $roles): array;

    /**
     * Return unique list of permission filter by roles
     * @param array $roles
     * @return string[]
     */
    public function getUniquePermissions(array $roles): array;

    /**
     * Return all roles
     * @return array
     */
    public function all(): array;

    public function removeRoles(array|string $roles): void;

    public function createRole(string $role, array|string $permissions);

    public function updateRole(string $role, array|string $permissions);
}