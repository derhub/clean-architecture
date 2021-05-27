<?php

namespace Derhub\Business\Infrastructure\Persistence\Doctrine\Type;

use Doctrine\DBAL\Types\StringType;
use Derhub\Business\Model\Values\Slug;
use Derhub\Shared\Persistence\Doctrine\Types\DbalTyping;

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