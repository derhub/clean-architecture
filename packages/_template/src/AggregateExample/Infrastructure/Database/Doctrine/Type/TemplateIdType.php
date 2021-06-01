<?php

namespace Derhub\Template\AggregateExample\Infrastructure\Database\Doctrine\Type;

use Derhub\Shared\Database\Doctrine\Types\DbalTyping;
use Derhub\Template\AggregateExample\Model\Values\TemplateId;
use Doctrine\DBAL\Types\GuidType;

class TemplateIdType extends GuidType
{
    use DbalTyping;

    public const NAME = 'template_id';

    public function defineName(): string
    {
        return self::NAME;
    }

    public function defineClass(): string
    {
        return TemplateId::class;
    }

    public function convertToRaw(mixed $value): string
    {
        return $value->toString();
    }

    public function defineEmptyValueForPHP(mixed $value): mixed
    {
        return null;
    }

    public function convertFromRaw(mixed $value): TemplateId
    {
        return TemplateId::fromString($value);
    }
}
