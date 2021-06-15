<?php

namespace Derhub\IdentityAccess\AccessProvider\Services\UserRoles;

use Derhub\IdentityAccess\AccessProvider\Model\UserRolesRepository;

class RemoveUserRolesHandler
{
    public function __construct(
        private UserRolesRepository $repo
    ) {
    }

    public function __invoke(UpdateUserRoles $req)
    {
        $this->repo->removeRoles($req->userId(), $req->roles());
    }
}