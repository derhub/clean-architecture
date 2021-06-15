<?php

namespace Derhub\IdentityAccess\AccessProvider\Services\UserRoles;

use Derhub\IdentityAccess\AccessProvider\Model\UserRolesRepository;

class UpdateUserRolesHandler
{
    public function __construct(
        private UserRolesRepository $repo
    ) {
    }

    public function __invoke(UpdateUserRoles $req)
    {
        $this->repo->assignRoles($req->userId(), $req->roles());
    }
}