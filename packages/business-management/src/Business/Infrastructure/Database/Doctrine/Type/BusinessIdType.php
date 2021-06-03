<?php

namespace Derhub\BusinessManagement\Business\Infrastructure\Database\Doctrine\Type;

use Derhub\Shared\Database\Doctrine\Types\DbalTyping;
use Doctrine\DBAL\Types\GuidType;
use Derhub\BusinessManagement\Business\Model\Values\BusinessId;

class BusinessIdType extends GuidType
{
    use DbalTyping;

    public const NAME = 'business_id';

    public function convertFromRaw(mixed $value): BusinessId
    {
        return BusinessId::fromBytes($value);
    }

    public function convertToRaw(mixed $value): string
    {
        return $value->toBytes();
    }

    public function defineClass(): string
    {
        return BusinessId::class;
    }

    public function defineEmptyValueForPHP(mixed $value): BusinessId
    {
        return new BusinessId();
    }

    public function defineName(): string
    {
        return self::NAME;
    }
}
