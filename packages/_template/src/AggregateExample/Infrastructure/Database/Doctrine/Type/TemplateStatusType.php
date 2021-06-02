<?php

namespace Derhub\Template\AggregateExample\Infrastructure\Database\Doctrine\Type;

use Derhub\Shared\Database\Doctrine\Types\DbalTyping;
use Derhub\Template\AggregateExample\Model\Values\Status;
use Doctrine\DBAL\Types\IntegerType;

class TemplateStatusType implements IntegerType
{
    use DbalTyping;

    public const NAME = 'template_status';

    public function defineName(): string
    {
        return self::NAME;
    }

    public function convertToRaw(mixed $value): int
    {
        return $value->toInt();
    }

    public function convertFromRaw(mixed $value): Status
    {
        return Status::fromString($value);
    }

    public function defineEmptyValueForPHP(mixed $value): Status
    {
        return new Status();
    }

    public function defineClass(): string
    {
        return Status::class;
    }
}
