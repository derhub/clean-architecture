<?php

namespace Derhub\IdentityAccess\Account\Services\Credentials;

use Derhub\IdentityAccess\Account\Model\UserAccountRepository;
use Derhub\IdentityAccess\Account\Model\Values\UserId;

class ChangeRememberTokenHandler
{
    public function __construct(
        private UserAccountRepository $repo
    ) {
    }

    public function __invoke(ChangeRememberToken $req): void
    {
        /** @var \Derhub\IdentityAccess\Account\Model\UserAccount $model */
        $model = $this->repo->get(UserId::fromString($req->userId()));
        $model->changeRememberToken($req->token());
        $this->repo->save($model);
    }
}