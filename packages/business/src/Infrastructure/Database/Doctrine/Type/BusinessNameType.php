<?php

namespace Derhub\Business\Infrastructure\Persistence\Doctrine\Type;

use Doctrine\DBAL\Types\StringType;
use Derhub\Business\Model\Values\Name;
use Derhub\Shared\Persistence\Doctrine\Types\DbalTyping;

class BusinessNameType extends StringType
{
    use DbalTyping;

    public const NAME = 'business_name';

    public function defineName(): string
    {
        return self::NAME;
    }

    public function defineEmptyValueForPHP(mixed $value): Name
    {
        return new Name();
    }

    public function defineClass(): string
    {
        return Name::class;
    }

    public function convertToRaw(mixed $value): string
    {
        return $value->toString();
    }

    public function convertFromRaw(mixed $value): Name
    {
        return Name::fromString($value);
    }
}
