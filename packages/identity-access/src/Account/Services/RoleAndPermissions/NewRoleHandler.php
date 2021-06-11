<?php

namespace Derhub\IdentityAccess\Account\Services\RoleAndPermissions;

use Derhub\IdentityAccess\Account\Infrastructure\RoleRepository;
use Derhub\IdentityAccess\Account\Model\Values\Role;
use Derhub\IdentityAccess\Account\Services\CommonCommandResponse;

class NewRoleHandler
{
    public function __construct(
        private RoleRepository $repo,
    ) {
    }

    public function __invoke(
        NewRole $msg
    ): CommonCommandResponse {
        $this->repo->newRole(
            Role::fromString($msg->role()),
            $msg->permissions(),
        );

        return new CommonCommandResponse($msg->role());
    }
}