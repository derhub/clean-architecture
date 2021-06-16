<?php

namespace Derhub\IdentityAccess\Account\Services\Registration;

use Derhub\IdentityAccess\Account\Model\UserAccount;
use Derhub\IdentityAccess\Account\Model\UserAccountRepository;
use Derhub\IdentityAccess\Account\Model\Values\Email;
use Derhub\IdentityAccess\Account\Model\Values\HashedPassword;
use Derhub\IdentityAccess\Account\Model\Values\UserId;
use Derhub\IdentityAccess\Account\Model\Values\Username;
use Derhub\IdentityAccess\Account\Services\CommonCommandResponse;
use Derhub\Laravel\IdentityAccess\Encryption\PasswordEncryptor;
use Derhub\Shared\Message\Command\CommandResponse;

class RegisterUserAccountHandler
{

    public function __construct(
        private UserAccountRepository $repo,
        private PasswordEncryptor $encryptor,
    ) {
    }

    public function __invoke(RegisterUserAccount $msg): CommandResponse
    {
        $userId = $this->repo->getNextId();
        $password = HashedPassword::fromString(
            $this->encryptor->encrypt($msg->password())
        );
        $model = UserAccount::register(
            userId: $userId,
            email: Email::fromString($msg->email()),
            username: Username::fromString($msg->username()),
            password: $password
        );
        $this->repo->save($model);

        return new CommonCommandResponse($model->aggregateRootId());
    }
}