<?php

namespace Derhub\Business\Infrastructure\Persistence\Doctrine\Type;

use Doctrine\DBAL\Types\StringType;
use Derhub\Business\Model\Values\OwnerId;
use Derhub\Shared\Persistence\Doctrine\Types\DbalTyping;

class BusinessOwnerIdType extends StringType
{
    use DbalTyping;

    public const NAME = 'business_owner_id';

    public function defineName(): string
    {
        return self::NAME;
    }

    public function defineClass(): string
    {
        return OwnerId::class;
    }

    public function convertToRaw(mixed $value): string
    {
        return $value->toString();
    }

    public function defineEmptyValueForPHP(mixed $value): mixed
    {
        return null;
    }

    public function convertFromRaw(mixed $value): OwnerId
    {
        return OwnerId::fromString($value);
    }
}
