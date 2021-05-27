<?php

namespace Derhub\Business\Infrastructure\Persistence\Doctrine\Type;

use Doctrine\DBAL\Types\StringType;
use Derhub\Business\Model\Values\Country;
use Derhub\Shared\Persistence\Doctrine\Types\DbalTyping;

class BusinessCountryType extends StringType
{
    use DbalTyping;

    public const NAME = 'business_country';

    public function defineName(): string
    {
        return self::NAME;
    }

    public function convertToRaw(mixed $value): mixed
    {
        return $value->toString();
    }

    public function convertFromRaw(mixed $value): Country
    {
        return Country::fromString($value);
    }

    public function defineEmptyValueForPHP(mixed $value): Country
    {
        return new Country();
    }

    public function defineClass(): string
    {
        return Country::class;
    }
}