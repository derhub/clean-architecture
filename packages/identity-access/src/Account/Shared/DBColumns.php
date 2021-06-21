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


    public const DBAL_USERID = 'id';
    public const DBAL_EMAIL = 'email';
    public const DBAL_USERNAME = 'username';
    public const DBAL_PASSWORD = 'password';

    public const DBAL_REMEMBER_TOKEN = 'remember_token';
    public const DBAL_TWO_FACTOR_SECRETE = 'two_factor_secret';
    public const DBAL_TWO_FACTOR_RECOVER_CODES = 'two_factor_recovery_codes';

    public const DBAL_UPDATED_AT = 'updated_at';
    public const DBAL_CREATED_AT = 'created_at';
    public const DBAL_STATUS = 'status';
}