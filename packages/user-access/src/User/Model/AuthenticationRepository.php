<?php

namespace Derhub\UserAccess\User\Model;


use Derhub\UserAccess\User\Model\Values\Password;
use Derhub\UserAccess\User\Model\Values\UserId;
use Derhub\UserAccess\User\Model\Values\Username;

interface AuthenticationRepository
{
    public function authenticate(Username $username, Password $password): Authentication;

    public function authenticateToken(UserId $fromString, string $token): Authentication;
}
