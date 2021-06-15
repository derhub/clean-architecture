<?php
declare(strict_types=1);

namespace Derhub\IdentityAccess\AccessProvider\Model;

/**
 * Manges roles and permissions and permission checking
 */
interface AccessManagement
{
    public function roles(): array;

    public function rolePermissions(): array;

    public function hasRootAccess(): bool;

    public function hasPermissions(string|array $permissions): bool;
}
