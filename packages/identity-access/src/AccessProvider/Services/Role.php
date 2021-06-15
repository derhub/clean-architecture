<?php

namespace Derhub\IdentityAccess\AccessProvider\Services;

use Derhub\IdentityAccess\AccessProvider\Shared\AccessValues;
use Derhub\Shared\Utils\Assert;

class Role implements \Stringable
{
    public const ALLOWED = 1;
    public const DENIED = 0;
    private array $wildcardPermissions = [];
    private array $permissions = [];

    public function __construct(
        private string $role,
        array $permissions = []
    ) {
        foreach ($permissions as $permission) {
            $this->permissions[$permission] = $permission;

            if ($this->isWildcard($permission)) {
                $this->addWildcardPermission($permission);
            }
        }
    }

    public function __toString(): string
    {
        return $this->name();
    }

    public function hasRootAccess(): bool
    {
        return $this->role === AccessValues::SUPER_ADMIN_ROLE;
    }

    private function addWildcardPermission(string $permission): void
    {
        $this->assertWildcardPermission($permission);
        $pattern = preg_quote($permission, '#');
        $pattern = str_replace('\*', '.*', $pattern);
        $this->wildcardPermissions[$permission] = '#^'.$pattern.'\z#u';
    }

    public function name(): string
    {
        return $this->role;
    }

    public function permissions(): array
    {
        return $this->permissions;
    }

    public function addPermissions(string|array ...$permissions): void
    {
        $this->addOrRemovePermissions($permissions, true);
    }

    public function removePermissions(string|array ...$permissions): void
    {
        $this->addOrRemovePermissions($permissions, false);
    }

    public function hasPermissions(string|array ...$permissions): bool
    {
        return $this->checkPermission($permissions);
    }

    private function addOrRemovePermissions(
        string|array $permissions,
        bool $isAdd = true
    ): void {
        // super admin dont need permissions
        if ($this->hasRootAccess()) {
            throw new \Exception(
                'adding permission to super admins is not permitted'
            );
            //return;
        }

        foreach ($permissions as $permission) {
            if (\is_array($permission)) {
                $this->addOrRemovePermissions($permission, $isAdd);
                continue;
            }

            if (! $isAdd) {
                unset($this->permissions[$permission]);
                continue;
            }

            $this->permissions[$permission] = $permission;

            if ($this->isWildcard($permission)) {
                $this->addWildcardPermission($permission);
            }
        }
    }

    private function isWildcard(string $permission): bool
    {
        return \str_contains($permission, '*');
    }

    private function hasMatchWildcardPermission(string $permission): bool
    {
        foreach ($this->wildcardPermissions as $key => $wildcardPattern) {
            if (preg_match($wildcardPattern, $permission) === 1) {
                return true;
            }
        }

        return false;
    }

    private function assertWildcardPermission(string $permission): void
    {
        $parts = explode(':', $permission, 3);
        Assert::true(count($parts) === 3, 'Invalid permission format');
        Assert::true(
            ! \str_contains($parts[0], '*')
            && ! \str_contains($parts[1], '*'),
            'Permission type and action cannot have *'
        );
    }

    /**
     * @param array $permissions
     * @return bool
     */
    protected function checkPermission(array $permissions): bool
    {
        // super admin is always allowed and not denied
        if ($this->hasRootAccess()) {
            return true;
        }

        foreach ($permissions as $permission) {
            if (\is_array($permission)) {
                $pass = $this->checkPermission($permission);

                if (! $pass) {
                    return false;
                }

                continue;
            }

            $hasAccess = isset($this->permissions[$permission])
                || $this->hasMatchWildcardPermission($permission);

            if (! $hasAccess) {
                return false;
            }
        }

        return true;
    }
}