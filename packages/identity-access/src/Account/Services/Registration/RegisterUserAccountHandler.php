<?php

namespace Derhub\IdentityAccess\Account\Services\Registration;

use Derhub\IdentityAccess\Account\Model\UserAccount;
use Derhub\IdentityAccess\Account\Model\UserAccountRepository;
use Derhub\IdentityAccess\Account\Model\Values\Email;
use Derhub\IdentityAccess\Account\Model\Values\Password;
use Derhub\IdentityAccess\Account\Model\Values\UserId;
use Derhub\IdentityAccess\Account\Model\Values\Username;
use Derhub\IdentityAccess\Account\Services\CommonCommandResponse;
use Derhub\Shared\Message\Command\CommandResponse;

class RegisterUserAccountHandler
{

    public function __construct(
        private UserAccountRepository $repo
    ) {
    }

    public function __invoke(RegisterUserAccount $msg): CommandResponse
    {
        $userId = $this->repo->getNextId();
        $model = UserAccount::register(
            userId: $userId,
            email: Email::fromString($msg->email()),
            username: Username::fromString($msg->username()),
            password: Password::fromString($msg->password())
        );
        $this->repo->save($model);

        return new CommonCommandResponse($model->aggregateRootId());
    }
}