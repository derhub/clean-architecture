<?php

namespace Derhub\IdentityAccess\AccessProvider\Services\RolePermission;

use Derhub\IdentityAccess\AccessProvider\Model\RoleAndPermissionsRepository;

class UpdateRolePermissionsHandler
{
    public function __construct(
        private RoleAndPermissionsRepository $repo,
    ) {
    }

    public function __invoke(CreateRoleAndPermissions $req)
    {
        $this->repo->updateRole($req->role(), $req->permissions());
    }
}