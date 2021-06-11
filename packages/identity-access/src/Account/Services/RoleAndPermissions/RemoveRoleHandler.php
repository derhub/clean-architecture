<?php

namespace Derhub\IdentityAccess\Account\Services\RoleAndPermissions;

use Derhub\IdentityAccess\Account\Infrastructure\RoleRepository;
use Derhub\IdentityAccess\Account\Model\Values\Role;
use Derhub\IdentityAccess\Account\Services\CommonCommandResponse;

class RemoveRoleHandler
{
    public function __construct(
        private RoleRepository $repo,
    ) {
    }

    public function __invoke(
        RemoveRole $msg
    ): CommonCommandResponse {
        $this->repo->removeRole(Role::fromString($msg->role()));

        return new CommonCommandResponse(null);
    }
}