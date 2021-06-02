<?php

namespace Derhub\BusinessManagement\Business\Infrastructure\Database\Doctrine\Type;

use Derhub\Shared\Database\Doctrine\Types\DbalTyping;
use Doctrine\DBAL\Types\StringType;
use Derhub\BusinessManagement\Business\Model\Values\Name;

class BusinessNameType extends StringType
{
    use DbalTyping;

    public const NAME = 'business_name';

    public function convertFromRaw(mixed $value): Name
    {
        return Name::fromString($value);
    }

    public function convertToRaw(mixed $value): string
    {
        return $value->toString();
    }

    public function defineClass(): string
    {
        return Name::class;
    }

    public function defineEmptyValueForPHP(mixed $value): Name
    {
        return new Name();
    }

    public function defineName(): string
    {
        return self::NAME;
    }
}
