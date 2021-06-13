<?php

namespace Derhub\IdentityAccess\Account\Infrastructure\Database\Doctrine\Types;

use Derhub\IdentityAccess\Account\Model\Values\Email;
use Doctrine\DBAL\Types\StringType;

class EmailType extends StringType
{
    use WithStringTyping;

    public const NAME = 'user_account_email';

    public function defineClass(): string
    {
        return Email::class;
    }
}