<?php

namespace Derhub\IdentityAccess\Account\Infrastructure;


use Derhub\IdentityAccess\Account\Infrastructure\Authentication;
use Derhub\IdentityAccess\Account\Model\Values\Password;
use Derhub\IdentityAccess\Account\Model\Values\Username;

interface AuthenticationRepository
{
    public function authenticate(Username $username, Password $password): Authentication;
}
