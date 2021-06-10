<?php

namespace Derhub\UserAccess\User\Services\TokenAuthentication;

use Derhub\UserAccess\User\Model\AuthenticationRepository;
use Derhub\UserAccess\User\Model\Values\UserId;
use Derhub\UserAccess\User\Services\CommonCommandResponse;

class AuthenticateUserTokenHandler
{
    public function __construct(
        private AuthenticationRepository $repo
    ) {
    }

    public function __invoke(AuthenticateUserToken $msg): CommonCommandResponse
    {
        $auth = $this->repo->authenticateToken(
            UserId::fromString($msg->userId()),
            $msg->token()
        );

        $res = new CommonCommandResponse($msg->userId());

        if (! $auth->success()) {
            $res->addError('authentication', $auth->whyFailed());
        }

        return $res;
    }
}