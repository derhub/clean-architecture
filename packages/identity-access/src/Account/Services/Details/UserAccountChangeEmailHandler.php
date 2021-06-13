<?php

namespace Derhub\IdentityAccess\Account\Services\Details;

use Derhub\IdentityAccess\Account\Model\UserAccountRepository;
use Derhub\IdentityAccess\Account\Model\Values\Email;
use Derhub\IdentityAccess\Account\Model\Values\UserId;
use Derhub\IdentityAccess\Account\Services\CommonCommandResponse;
use Derhub\Shared\Message\Command\CommandResponse;

class UserAccountChangeEmailHandler
{
    public function __construct(
        private UserAccountRepository $repo
    ) {
    }

    public function __invoke(UserAccountChangeEmail $msg): CommandResponse
    {
        $userId = UserId::fromString($msg->userId());

        /** @var \Derhub\IdentityAccess\Account\Model\UserAccount $model */
        $model = $this->repo->get($userId);

        $model->changeEmail(Email::fromString($msg->email()));

        $this->repo->save($model);

        return new CommonCommandResponse($msg->userId());
    }
}