<?php

namespace Derhub\IdentityAccess\Account\Infrastructure;

use Derhub\IdentityAccess\Account\Infrastructure\Authorization;
use Derhub\IdentityAccess\Account\Model\Values\UserResource;
use Derhub\IdentityAccess\Account\Model\Values\UserId;

interface AuthorizationRepository
{
    public function authorize(
        UserId $userId,
        UserResource $resource,
    ): Authorization;

    public function assignRoles(UserId $userId, array $roles): bool;

    public function removeRoles(UserId $userId, array $roles): bool;
}