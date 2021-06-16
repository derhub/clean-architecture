<?php

namespace Derhub\IdentityAccess\Account\Services\DetailsUpdate;

use Derhub\IdentityAccess\Account\Model\UserAccountRepository;
use Derhub\IdentityAccess\Account\Model\Values\HashedPassword;
use Derhub\IdentityAccess\Account\Model\Values\UserId;
use Derhub\IdentityAccess\Account\Services\CommonCommandResponse;
use Derhub\Shared\Message\Command\CommandResponse;

class ChangeUserAccountPasswordHandler
{
    public function __construct(
        private UserAccountRepository $repo
    ) {
    }

    public function __invoke(ChangeUserAccountPassword $msg): CommandResponse
    {
        $userId = UserId::fromString($msg->userId());

        /** @var \Derhub\IdentityAccess\Account\Model\UserAccount $model */
        $model = $this->repo->get($userId);

        $model->changePassword(HashedPassword::fromString($msg->password()));

        $this->repo->save($model);

        return new CommonCommandResponse($msg->userId());
    }
}