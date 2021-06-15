<?php

namespace Derhub\IdentityAccess\AccessProvider\Services;

use Derhub\IdentityAccess\AccessProvider\Services\UserRoles\UserAccessQueryResponse;
use Derhub\IdentityAccess\AccessProvider\Shared\AccessValues;

/**
 * Map roles and permissions
 */
class AccessManagerFactory
{
    public static function createAccessManagerFromQuery(
        UserAccessQueryResponse $response
    ): UserAccessManager {
        return new UserAccessManager(
            $response->user(),
            $response->roles(),
            $response->rolePermissions(),
        );
    }

    public static function createRoleManager(
        array $roles,
        array $permissions
    ): RoleManager {
        $rbac = new RoleManager();

        foreach ($roles as $role) {
            $rbac->addRole(new Role($role));
        }

        foreach ($permissions as $config) {
            if ($config['role'] !== AccessValues::SUPER_ADMIN_ROLE
                && $rbac->hasRole($config['role'])) {
                $rbac->addPermissions($config['role'], $config['permission']);
            }
        }

        return $rbac;
    }

    /**
     * Returns RoleManager with root role or
     * One role with all the permission given
     * @param string $user
     * @param array $roles
     * @param array $permissions
     * @return \Derhub\IdentityAccess\AccessProvider\Services\RoleManager
     */
    public static function createUserPermissionManager(
        string $user,
        array $roles,
        array $permissions
    ): RoleManager {
        $rbac = new RoleManager();

        // we assume that super admin users have one role
        if (\in_array(AccessValues::SUPER_ADMIN_ROLE, $roles, true)) {
            $rbac->addRole(new Role(AccessValues::SUPER_ADMIN_ROLE));
            return $rbac;
        }

        // combine all user permission in one role for more easy checking
        $userRole = new Role($user);
        $userRole->addPermissions($permissions);
        $rbac->addRole($userRole);

        return $rbac;
    }

}