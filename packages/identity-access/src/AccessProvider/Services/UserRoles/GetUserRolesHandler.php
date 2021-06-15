<?php

namespace Derhub\IdentityAccess\AccessProvider\Services\UserRoles;

use Derhub\IdentityAccess\AccessProvider\Model\RoleAndPermissionsRepository;
use Derhub\IdentityAccess\AccessProvider\Model\UserRolesRepository;
use Derhub\Shared\Message\Query\QueryResponse;

class GetUserRolesHandler
{
    public function __construct(
        private UserRolesRepository $authRepo,
        private RoleAndPermissionsRepository $roleRepo,
    ) {
    }

    public function __invoke(
        GetUserRoles $req
    ): QueryResponse {
        $roles = $this->authRepo->getRoles($req->user());
        $permissions = $this->roleRepo->getUniquePermissions($roles);

        return new UserAccessQueryResponse(
            $req->user(),
            $roles,
            $permissions,
        );
    }
}