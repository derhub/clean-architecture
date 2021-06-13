<?php

namespace Derhub\IdentityAccess\Account\Services;

use Derhub\Shared\Query\QueryItem;
use Derhub\Shared\Query\QueryItemMapper;

class UserAccountMapper implements QueryItemMapper
{

    public function fromArray(array $data): QueryItem
    {
        return new UserAccount(
            id: $data['userId']->toString(),
            status: $data['status']->toInt(),
            username: $data['credentials.username']->toString(),
            email: $data['credentials.email']->toString(),
            password: $data['credentials.password']->toString(),
            createdAt: $data['createdAt']->toString(),
            updatedAt: $data['updatedAt']->toString(),
        );
    }
}