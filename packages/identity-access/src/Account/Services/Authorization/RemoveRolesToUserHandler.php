<?php

namespace Derhub\IdentityAccess\Account\Services\Authorization;


use Derhub\IdentityAccess\Account\Infrastructure\AuthorizationRepository;
use Derhub\IdentityAccess\Account\Model\Values\UserId;
use Derhub\IdentityAccess\Account\Services\CommonCommandResponse;

class RemoveRolesToUserHandler
{
    public function __construct(
        private AuthorizationRepository $repo,
    ) {
    }

    public function __invoke(RemoveRolesToUser $msg): CommonCommandResponse
    {
        $this->repo->assignRoles(
            UserId::fromString($msg->userId()),
            $msg->roles()
        );

        return new CommonCommandResponse($msg->userId());
    }
}