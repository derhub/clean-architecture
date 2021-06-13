<?php

namespace Derhub\IdentityAccess\Account\Services\Details;

use Derhub\IdentityAccess\Account\Model\UserAccountRepository;
use Derhub\IdentityAccess\Account\Model\Values\Password;
use Derhub\IdentityAccess\Account\Model\Values\UserId;
use Derhub\IdentityAccess\Account\Services\CommonCommandResponse;
use Derhub\Shared\Message\Command\CommandResponse;

class UserAccountChangePasswordHandler
{
    public function __construct(
        private UserAccountRepository $repo
    ) {
    }

    public function __invoke(UserAccountChangePassword $msg): CommandResponse
    {
        $userId = UserId::fromString($msg->userId());

        /** @var \Derhub\IdentityAccess\Account\Model\UserAccount $model */
        $model = $this->repo->get($userId);

        $model->changePassword(Password::fromString($msg->password()));

        $this->repo->save($model);

        return new CommonCommandResponse($msg->userId());
    }
}