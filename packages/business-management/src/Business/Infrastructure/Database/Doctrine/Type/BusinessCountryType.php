<?php

namespace Derhub\BusinessManagement\Business\Infrastructure\Database\Doctrine\Type;

use Derhub\Shared\Database\Doctrine\Types\DbalTyping;
use Doctrine\DBAL\Types\StringType;
use Derhub\BusinessManagement\Business\Model\Values\Country;

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
