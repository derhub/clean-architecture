<?php

namespace Derhub\IdentityAccess\Account\Infrastructure\Database\Doctrine\Types;

use Derhub\IdentityAccess\Account\Model\Values\UserId;
use Derhub\Shared\Database\Doctrine\Types\DbalTyping;
use Doctrine\DBAL\Types\GuidType;

class UserIdType extends GuidType
{
    use DbalTyping;

    public const NAME = 'user_account_id';

    public function convertFromRaw(mixed $value): UserId
    {
        return UserId::fromBytes($value);
    }

    public function convertToRaw(mixed $value): string
    {
        return $value->toBytes();
    }

    public function defineClass(): string
    {
        return UserId::class;
    }

    public function defineEmptyValueForPHP(mixed $value): UserId
    {
        return new UserId();
    }

    public function defineName(): string
    {
        return self::NAME;
    }
}