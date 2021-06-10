<?php

namespace Derhub\UserAccess\User\Services\Authorization;

use Derhub\UserAccess\User\Model\AuthorizationRepository;
use Derhub\UserAccess\User\Model\Values\UserId;
use Derhub\UserAccess\User\Services\CommonCommandResponse;

class AuthorizeUserHandler
{
    public function __construct(
        private AuthorizationRepository $repo,
    ) {
    }

    public function __invoke(AuthorizeUser $msg): CommonCommandResponse
    {
        $auth = $this->repo->authorize(
            UserId::fromString($msg->userId()),
            $msg->permission(),
            $msg->resourceId(),
        );

        $res = new CommonCommandResponse($msg->userId());

        if (! $auth->success()) {
            $res->addError('authorization', $auth->whyFailed());
        }

        return $res;
    }
}