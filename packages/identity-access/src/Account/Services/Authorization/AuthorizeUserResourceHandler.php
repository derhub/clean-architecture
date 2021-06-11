<?php

namespace Derhub\IdentityAccess\Account\Services\Authorization;

use Derhub\IdentityAccess\Account\Infrastructure\AuthorizationRepository;
use Derhub\IdentityAccess\Account\Model\Values\UserId;
use Derhub\IdentityAccess\Account\Model\Values\UserResource;
use Derhub\IdentityAccess\Account\Services\CommonCommandResponse;

class AuthorizeUserResourceHandler
{
    public function __construct(
        private AuthorizationRepository $repo,
    ) {
    }

    public function __invoke(AuthorizeUserResource $msg): CommonCommandResponse
    {
        $resourceUser = null;
        if (\is_string($msg->resourceUserId())) {
            $resourceUser = UserId::fromString($msg->resourceUserId());
        }

        $resource = UserResource::with(
            userId: $resourceUser,
            id: $msg->resourceId(),
            type: $msg->resourceType(),
            value: $msg->resourceValue(),
        );


        $auth = $this->repo->authorize(
            UserId::fromString($msg->userId()),
            $resource,
        );

        $res = new CommonCommandResponse($msg->userId());

        if (! $auth->success()) {
            $res->addError('authorization', $auth->whyFailed());
        }

        return $res;
    }
}