<?php

namespace Derhub\IdentityAccess\Account\Services\DetailsUpdate;

use Derhub\IdentityAccess\Account\Model\UserAccountRepository;
use Derhub\IdentityAccess\Account\Model\Values\UserId;
use Derhub\IdentityAccess\Account\Model\Values\Username;
use Derhub\IdentityAccess\Account\Services\CommonCommandResponse;
use Derhub\Shared\Message\Command\CommandResponse;

class ChangeUserAccountUsernameHandler
{
    public function __construct(
        private UserAccountRepository $repo
    ) {
    }

    public function __invoke(ChangeUserAccountUsername $msg): CommandResponse
    {
        $userId = UserId::fromString($msg->userId());

        /** @var \Derhub\IdentityAccess\Account\Model\UserAccount $model */
        $model = $this->repo->get($userId);

        $model->changeUsername(Username::fromString($msg->username()));

        $this->repo->save($model);

        return new CommonCommandResponse($msg->userId());
    }
}