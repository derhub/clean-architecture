<?php

namespace Derhub\IdentityAccess\Account\Services\RoleAndPermissions;

use Derhub\IdentityAccess\Account\Infrastructure\RoleRepository;
use Derhub\IdentityAccess\Account\Model\Values\Permission;
use Derhub\IdentityAccess\Account\Model\Values\Role;
use Derhub\IdentityAccess\Account\Services\CommonCommandResponse;

class AssignPermissionsToRoleHandler
{
    public function __construct(
        private RoleRepository $repo,
    ) {
    }

    public function __invoke(
        AssignPermissionsToRole $msg
    ): CommonCommandResponse {
        $this->repo->givePermissions(
            Role::fromString($msg->role()),
            $msg->permissions(),
        );

        return new CommonCommandResponse($msg->role());
    }
}