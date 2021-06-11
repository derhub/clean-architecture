<?php

namespace Derhub\IdentityAccess\Account\Services\Authentication;

use Derhub\Shared\Message\Command\CommandResponse;
use Derhub\IdentityAccess\Account\Infrastructure\AuthenticationRepository;
use Derhub\IdentityAccess\Account\Model\Values\Password;
use Derhub\IdentityAccess\Account\Model\Values\Username;
use Derhub\IdentityAccess\Account\Services\CommonCommandResponse;

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