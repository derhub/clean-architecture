<?php

namespace Derhub\IdentityAccess\AccessProvider\Services;

use Derhub\IdentityAccess\AccessProvider\Shared\AccessValues;

class RoleManager
{
    protected array $roles = [];

    public function __construct(array $roles = [])
    {
        foreach ($roles as $role) {
            $this->addRole($role);
        }
    }

    public function hasRootAccess(): bool
    {
        return $this->hasRole(AccessValues::SUPER_ADMIN_ROLE);
    }

    public function addRole(Role $role): self
    {
        $this->roles[$role->name()] = $role;
        return $this;
    }

    public function removeRole(Role|string $role): self
    {
        $name = $role instanceof Role ? $role->name() : $role;
        if (! isset($this->roles[$name])) {
            return $this;
        }

        unset($this->roles[$name]);
        return $this;
    }

    public function hasRole(Role|string $role): bool
    {
        if ($role instanceof Role) {
            $role = $role->name();
        }
        return isset($this->roles[$role]);
    }

    public function getRole(string $roleName): ?Role
    {
        return $this->roles[$roleName] ?? null;
    }


    public function addPermissions(
        Role|string $role,
        string|array $permissions
    ): self {
        $this->verifyRole($role);
        if (\is_string($role)) {
            $role = $this->getRole($role);
        }

        $role->addPermissions($permissions);
        return $this;
    }

    public function removePermissions(
        Role|string $role,
        string|array $permissions
    ): self {
        $this->verifyRole($role);
        if (\is_string($role)) {
            $role = $this->getRole($role);
        }

        $role->removePermissions($permissions);
        return $this;
    }

    /**
     * Return true if role has permission
     */
    public function hasPermission(
        Role|string $role,
        string|array $permissions
    ): bool {
        $this->verifyRole($role);

        if (\is_string($role)) {
            $role = $this->getRole($role);
        }

        return $role->hasPermissions($permissions);
    }

    private function verifyRole(Role|string $role): void
    {
        if (! $this->hasRole($role)) {
            throw new \InvalidArgumentException(
                \sprintf(
                    'Role %s not found',
                    $role,
                ),
            );
        }
    }

    /**
     * @return \Derhub\IdentityAccess\AccessProvider\Services\Role[]
     */
    public function roles(): array
    {
        return $this->roles;
    }
}