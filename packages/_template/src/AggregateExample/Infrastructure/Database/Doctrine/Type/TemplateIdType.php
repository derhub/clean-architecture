<?php

namespace Derhub\Template\AggregateExample\Infrastructure\Database\Doctrine\Type;

use Derhub\Shared\Database\Doctrine\Types\DbalTyping;
use Derhub\Template\AggregateExample\Model\Values\TemplateId;
use Doctrine\DBAL\Types\GuidType;

class TemplateIdType extends GuidType
{
    use DbalTyping;

    public const NAME = 'template_id';

    public function convertFromRaw(mixed $value): TemplateId
    {
        return TemplateId::fromString($value);
    }

    public function convertToRaw(mixed $value): string
    {
        return $value->toString();
    }

    public function defineClass(): string
    {
        return TemplateId::class;
    }

    public function defineEmptyValueForPHP(mixed $value): mixed
    {
        return null;
    }

    public function defineName(): string
    {
        return self::NAME;
    }
}
