<?php

namespace Derhub\IdentityAccess\Account\Shared;

class DBColumns
{
    public const USERID = 'userId';
    public const EMAIL = 'credentials.email';
    public const USERNAME = 'credentials.username';
    public const PASSWORD = 'credentials.password';

    public const REMEMBER_TOKEN = 'credentials.rememberToken';
    public const TWO_FACTOR_SECRETE = 'credentials.twoFactorSecrete';
    public const TWO_FACTOR_RECOVER_CODES = 'credentials.twoFactorRecoveryCodes';

    public const UPDATED_AT = 'updatedAt';
    public const CREATED_AT = 'createdAt';
    public const STATUS = 'status';
}