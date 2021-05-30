<?php

namespace Derhub\Template\Infrastructure\Database\Doctrine\Type;

use Derhub\Shared\Database\Doctrine\Types\DbalTyping;
use Doctrine\DBAL\Types\StringType;
use Derhub\Template\Model\Values\Name;

class TemplateNameType extends StringType
{
    use DbalTyping;

    public const NAME = 'template_name';

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
