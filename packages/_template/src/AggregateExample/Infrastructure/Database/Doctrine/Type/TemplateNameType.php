<?php

namespace Derhub\Template\AggregateExample\Infrastructure\Database\Doctrine\Type;

use Derhub\Shared\Database\Doctrine\Types\DbalTyping;
use Derhub\Template\AggregateExample\Model\Values\Name;
use Doctrine\DBAL\Types\StringType;

class TemplateNameType extends StringType
{
    use DbalTyping;

    public const NAME = 'template_name';

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
