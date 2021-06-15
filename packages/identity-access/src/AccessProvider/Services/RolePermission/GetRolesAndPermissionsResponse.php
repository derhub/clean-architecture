<?php

namespace Derhub\IdentityAccess\AccessProvider\Services\RolePermission;

use Derhub\Shared\Message\Query\AbstractQueryResponse;

class GetRolesAndPermissionsResponse extends AbstractQueryResponse
{
    public function roles(): array
    {
        return $this->results['roles'];
    }

    public function rolePermissions(): array
    {
        return $this->results['role_permissions'];
    }
}