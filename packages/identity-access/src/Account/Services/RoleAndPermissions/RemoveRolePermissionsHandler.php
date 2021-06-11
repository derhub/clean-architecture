<?php

namespace Derhub\IdentityAccess\Account\Services\RoleAndPermissions;

use Derhub\Shared\Message\Command\AbstractCommandResponse;
use Derhub\IdentityAccess\Account\Infrastructure\RoleRepository;
use Derhub\IdentityAccess\Account\Model\Values\Role;
use Derhub\IdentityAccess\Account\Services\CommonCommandResponse;

class RemoveRolePermissionsHandler
{
    public function __construct(
        private RoleRepository $repo,
    ) {
    }

    public function __invoke(
        RemoveRolePermissions $msg
    ): CommonCommandResponse {
        $this->repo->removePermissions(
            Role::fromString($msg->role()),
            $msg->permissions(),
        );

        return new CommonCommandResponse($msg->role());
    }
}