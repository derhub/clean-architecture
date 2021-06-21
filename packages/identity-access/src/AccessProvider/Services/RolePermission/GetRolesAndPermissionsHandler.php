<?php

namespace Derhub\IdentityAccess\AccessProvider\Services\RolePermission;

use Derhub\IdentityAccess\AccessProvider\Model\RoleAndPermissionsRepository;
use Derhub\Shared\Message\Query\QueryResponse;

class GetRolesAndPermissionsHandler
{
    public function __construct(
        private RoleAndPermissionsRepository $repo
    ) {
    }

    public function __invoke(GetRolesAndPermissions $req): QueryResponse
    {
        $roles = $this->repo->all();
        $permission = $this->repo->getPermissions($roles);

        return new GetRolesAndPermissionsResponse(
            [
                'roles' => $roles,
                'role_permissions' => $permission,
            ]
        );
    }
}