<?php

namespace Derhub\IdentityAccess\AccessProvider\Services\RolePermission;

class GetRolesAndPermissions
{
    private int $version = 1;

    public function __construct()
    {
    }

    public function version(): int
    {
        return $this->version;
    }
}