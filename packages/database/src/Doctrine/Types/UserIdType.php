<?php

namespace Derhub\Shared\Database\Doctrine\Types;

use Doctrine\DBAL\Types\GuidType;
use Derhub\Shared\Values\UserId;

class UserIdType extends GuidType
{
    use DbalTyping;

    public const NAME = 'user_id';

    public function convertFromRaw(mixed $value): UserId
    {
        return UserId::fromString($value);
    }

    public function convertToRaw(mixed $value): string
    {
        return $value->toString();
    }

    public function defineClass(): string
    {
        return UserId::class;
    }

    public function defineEmptyValueForPHP(mixed $value): mixed
    {
        return new UserId();
    }

    public function defineName(): string
    {
        return self::NAME;
    }
}
