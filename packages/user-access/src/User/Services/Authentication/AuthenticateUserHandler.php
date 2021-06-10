<?php

namespace Derhub\UserAccess\User\Services\Authentication;

use Derhub\Shared\Message\Command\CommandResponse;
use Derhub\UserAccess\User\Model\AuthenticationRepository;
use Derhub\UserAccess\User\Model\Values\Password;
use Derhub\UserAccess\User\Model\Values\Username;
use Derhub\UserAccess\User\Services\CommonCommandResponse;

class AuthenticateUserHandler
{
    public function __construct(private AuthenticationRepository $repo)
    {
    }

    public function __invoke(AuthenticateUser $msg): CommandResponse
    {
        $auth = $this->repo->authenticate(
            Username::fromString($msg->username()),
            Password::fromString($msg->password())
        );

        $res = new CommonCommandResponse($auth->userId());

        if (! $auth->success()) {
            $res->addError('authentication', $auth->whyFailed());
        }

        return $res;
    }
}