<?php

namespace Derhub\BusinessManagement\Business\Infrastructure\Database\Doctrine\Type;

use Derhub\Shared\Database\Doctrine\Types\DbalTyping;
use Doctrine\DBAL\Types\StringType;
use Derhub\BusinessManagement\Business\Model\Values\Slug;

class BusinessSlugType extends StringType
{
    use DbalTyping;

    public const NAME = 'business_slug';

    public function defineName(): string
    {
        return self::NAME;
    }

    public function convertToRaw(mixed $value): string
    {
        return $value->toString();
    }

    public function defineEmptyValueForPHP(mixed $value): Slug
    {
        return new Slug();
    }

    public function defineClass(): string
    {
        return Slug::class;
    }

    public function convertFromRaw(mixed $value): Slug
    {
        return Slug::fromString($value);
    }
}
