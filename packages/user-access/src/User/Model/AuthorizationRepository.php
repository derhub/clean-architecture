<?php

namespace Derhub\UserAccess\User\Model;

use Derhub\UserAccess\User\Model\Values\UserId;

interface AuthorizationRepository
{
    public function authorize(
        UserId $userId,
        string $permission,
        mixed $resourceId
    ): Authorization;
}