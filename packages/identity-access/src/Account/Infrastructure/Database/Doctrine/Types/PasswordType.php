<?php

namespace Derhub\IdentityAccess\Account\Infrastructure\Database\Doctrine\Types;

use Derhub\IdentityAccess\Account\Model\Values\Password;
use Doctrine\DBAL\Types\StringType;

class PasswordType extends StringType
{
    use WithStringTyping;

    public const NAME = 'user_account_password';

    public function defineClass(): string
    {
        return Password::class;
    }
}