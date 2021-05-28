<?php

namespace EB\Template\Infrastructure\Persistence\Doctrine\Type;

use Doctrine\DBAL\Types\GuidType;
use EB\Template\Model\ValueObject\TemplateId;
use EB\Shared\Persistence\Doctrine\Types\DbalTyping;

class TemplateIdType extends GuidType
{
    use DbalTyping;

    public const NAME = 'Template_id';

    public function defineName(): string
    {
        return self::NAME;
    }

    public function defineClass(): string
    {
        return TemplateId::class;
    }

    public function defineMethodForGettingValue(mixed $value): string
    {
        return 'toString';
    }

    public function defineEmptyValueForPHP(mixed $value): mixed
    {
        return null;
    }
}
