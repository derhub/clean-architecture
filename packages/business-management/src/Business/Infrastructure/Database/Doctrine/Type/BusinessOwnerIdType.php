<?php

namespace Derhub\BusinessManagement\Business\Infrastructure\Database\Doctrine\Type;

use Derhub\Shared\Database\Doctrine\Types\DbalTyping;
use Doctrine\DBAL\Types\StringType;
use Derhub\BusinessManagement\Business\Model\Values\OwnerId;

class BusinessOwnerIdType extends StringType
{
    use DbalTyping;

    public const NAME = 'business_owner_id';

    public function convertFromRaw(mixed $value): OwnerId
    {
        return OwnerId::fromBytes($value);
    }

    public function convertToRaw(mixed $value): string
    {
        return $value->toBytes();
    }

    public function defineClass(): string
    {
        return OwnerId::class;
    }

    public function defineEmptyValueForPHP(mixed $value): OwnerId
    {
        return new OwnerId();
    }

    public function defineName(): string
    {
        return self::NAME;
    }
}
