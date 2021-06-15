<?php

namespace Derhub\IdentityAccess\AccessProvider\Services\RolePermission;

use Derhub\IdentityAccess\AccessProvider\Model\RoleAndPermissionsRepository;

class RemoveRolesHandler
{
    public function __construct(
        private RoleAndPermissionsRepository $repo,
    ) {
    }

    public function __invoke(RemoveRoles $req)
    {
        $this->repo->removeRoles($req->roles());
    }
}