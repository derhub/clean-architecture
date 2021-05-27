<?php

namespace Derhub\Business\Infrastructure\Persistence\Doctrine\Type;

use Doctrine\DBAL\Types\GuidType;
use Derhub\Business\Model\Values\BusinessId;
use Derhub\Shared\Persistence\Doctrine\Types\DbalTyping;

class BusinessIdType extends GuidType
{
    use DbalTyping;

    public const NAME = 'business_id';

    public function defineName(): string
    {
        return self::NAME;
    }

    public function defineClass(): string
    {
        return BusinessId::class;
    }

    public function convertToRaw(mixed $value): string
    {
        return $value->toString();
    }

    public function defineEmptyValueForPHP(mixed $value): mixed
    {
        return null;
    }

    public function convertFromRaw(mixed $value): BusinessId
    {
        return BusinessId::fromString($value);
    }
}
