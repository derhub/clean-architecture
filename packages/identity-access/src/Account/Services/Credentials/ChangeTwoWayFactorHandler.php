<?php

namespace Derhub\IdentityAccess\Account\Services\Credentials;

use Derhub\IdentityAccess\Account\Model\UserAccountRepository;
use Derhub\IdentityAccess\Account\Model\Values\UserId;

class ChangeTwoWayFactorHandler
{
    public function __construct(
        private UserAccountRepository $repo
    ) {
    }

    public function __invoke(ChangeTwoWayFactor $req): void
    {
        /** @var \Derhub\IdentityAccess\Account\Model\UserAccount $model */
        $model = $this->repo->get(UserId::fromString($req->userId()));
        $model->changeTwoWayFactor($req->secrete(), $req->recoveryCodes());
        $this->repo->save($model);
    }
}