<?php

namespace Derhub\IdentityAccess\AccessProvider\Services;

use Derhub\IdentityAccess\AccessProvider\Model\AccessManagement;

/**
 * This is a utility class for managing roles and permissions from query result.
 * It has a method for easy checking if has permission or is super admin
 */
final class UserAccessManager implements AccessManagement
{
    private ?RoleManager $manager;
    private array $roles;
    private array $permissions;
    private string $user;

    public function __construct(string $user, array $roles, array $permissions)
    {
        $this->manager = null;
        $this->user = $user;
        $this->roles = $roles;
        $this->permissions = $permissions;
    }

    /**
     * Return Role manager it creates user role manager property is null
     * @return \Derhub\IdentityAccess\AccessProvider\Services\RoleManager
     */
    private function getManager(): RoleManager
    {
        return $this->manager ??=
            AccessManagerFactory::createUserPermissionManager(
                $this->user(), $this->roles(), $this->rolePermissions()
            );
    }

    public function rolePermissions(): array
    {
        return $this->permissions;
    }

    public function roles(): array
    {
        return $this->roles;
    }

    public function user(): string
    {
        return $this->user;
    }

    public function hasRootAccess(): bool
    {
        return $this->getManager()->hasRootAccess();
    }

    public function hasPermissions(string|array $permissions): bool
    {
        if ($this->hasRootAccess()) {
            return true;
        }

        return $this->getManager()->hasPermission($this->user, $permissions);
    }

}