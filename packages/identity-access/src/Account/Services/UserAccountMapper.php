<?php

namespace Derhub\IdentityAccess\Account\Services;

use Derhub\IdentityAccess\Account\Shared\DBColumns;
use Derhub\Shared\Query\QueryItem;
use Derhub\Shared\Query\QueryItemMapper;

class UserAccountMapper implements QueryItemMapper
{

    public function fromArray(array $data): QueryItem
    {
        return new UserAccount(
            id: $data[DBColumns::USERID]->toString(),
            status: $data[DBColumns::STATUS]->toInt(),
            username: $data[DBColumns::USERNAME]->toString(),
            email: $data[DBColumns::EMAIL]->toString(),
            password: $data[DBColumns::PASSWORD]->toString(),
            rememberToken: $data[DBColumns::REMEMBER_TOKEN],
            twoFactorSecrete: $data[DBColumns::TWO_FACTOR_SECRETE],
            twoFactorRecoverCodes: $data[DBColumns::TWO_FACTOR_RECOVER_CODES],
            createdAt: $data[DBColumns::CREATED_AT]->toString(),
            updatedAt: $data[DBColumns::UPDATED_AT]->toString(),
        );
    }
}