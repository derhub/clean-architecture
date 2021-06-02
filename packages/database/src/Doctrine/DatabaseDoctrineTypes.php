<?php

namespace Derhub\Shared\Database\Doctrine;

use Derhub\Shared\Database\Doctrine\Types\DateTimeLiteralType;
use Derhub\Shared\Database\Doctrine\Types\EmailType;
use Derhub\Shared\Database\Doctrine\Types\UserIdType;
use Doctrine\DBAL\Types\Type;

class DatabaseDoctrineTypes
{
    public static function register(): void
    {
        Type::addType(UserIdType::NAME, UserIdType::class);
        Type::addType(EmailType::NAME, EmailType::class);
        Type::addType(
            DateTimeLiteralType::NAME,
            DateTimeLiteralType::class
        );
    }
}
