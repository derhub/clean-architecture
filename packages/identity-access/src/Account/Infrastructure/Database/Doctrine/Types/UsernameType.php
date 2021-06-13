<?php

namespace Derhub\IdentityAccess\Account\Infrastructure\Database\Doctrine\Types;

use Derhub\IdentityAccess\Account\Model\Values\Username;
use Doctrine\DBAL\Types\StringType;

class UsernameType extends StringType
{
    use WithStringTyping;

    public const NAME = 'user_account_username';

    public function defineClass(): string
    {
        return Username::class;
    }
}