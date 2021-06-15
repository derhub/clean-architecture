<?php

namespace Derhub\IdentityAccess\AccessProvider\Model;

interface UserRolesRepository
{
    /**
     * @return string[] List of roles
     */
    public function getRoles(string $user): array;

    public function hasRoles(string $user, array|string $roles): bool;

    public function assignRoles(string $user, array|string $roles): bool;

    public function removeRoles(string $user, array|string $roles): bool;
}