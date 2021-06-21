<?php

namespace Derhub\IdentityAccess\Account\Services;

use Derhub\IdentityAccess\Account\Model\Values\UserId;
use Derhub\IdentityAccess\Account\Shared\DBColumns;
use Derhub\Shared\Query\QueryItem;
use Derhub\Shared\Query\QueryItemMapper;

class UserAccountMapper implements QueryItemMapper
{

    public function fromArray(array $data): QueryItem
    {
        return new UserAccount(
            id: UserId::fromBytes($data[DBColumns::DBAL_USERID])->toString(),
            status: (int)$data[DBColumns::DBAL_STATUS],
            username: $data[DBColumns::DBAL_USERNAME],
            email: $data[DBColumns::DBAL_EMAIL],
            password: $data[DBColumns::DBAL_PASSWORD],
            rememberToken: $data[DBColumns::DBAL_REMEMBER_TOKEN],
            twoFactorSecrete: $data[DBColumns::DBAL_TWO_FACTOR_SECRETE],
            twoFactorRecoverCodes:
            $data[DBColumns::DBAL_TWO_FACTOR_RECOVER_CODES],
            createdAt: $data[DBColumns::DBAL_CREATED_AT],
            updatedAt: $data[DBColumns::DBAL_UPDATED_AT],
        );
    }
}