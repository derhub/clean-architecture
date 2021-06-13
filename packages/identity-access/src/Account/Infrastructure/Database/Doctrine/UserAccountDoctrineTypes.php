<?php

namespace Derhub\IdentityAccess\Account\Infrastructure\Database\Doctrine;

use Derhub\IdentityAccess\Account\Infrastructure\Database\Doctrine\Types\EmailType;
use Derhub\IdentityAccess\Account\Infrastructure\Database\Doctrine\Types\PasswordType;
use Derhub\IdentityAccess\Account\Infrastructure\Database\Doctrine\Types\RoleType;
use Derhub\IdentityAccess\Account\Infrastructure\Database\Doctrine\Types\StatusType;
use Derhub\IdentityAccess\Account\Infrastructure\Database\Doctrine\Types\UserIdType;
use Derhub\IdentityAccess\Account\Infrastructure\Database\Doctrine\Types\UsernameType;
use Doctrine\DBAL\Types\Type;

class UserAccountDoctrineTypes
{
    public static function register(): void
    {
        Type::addType(EmailType::NAME, EmailType::class);
        Type::addType(PasswordType::NAME, PasswordType::class);
        Type::addType(UserIdType::NAME, UserIdType::class);
        Type::addType(StatusType::NAME, StatusType::class);
        Type::addType(UsernameType::NAME, UsernameType::class);
    }
}