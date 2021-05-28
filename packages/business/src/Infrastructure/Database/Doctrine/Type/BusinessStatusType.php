<?php

namespace Derhub\Business\Infrastructure\Database\Doctrine\Type;

use Derhub\Shared\Database\Doctrine\Types\DbalTyping;
use Doctrine\DBAL\Types\IntegerType;
use Derhub\Business\Model\Values\Status;

class BusinessStatusType extends IntegerType
{
    use DbalTyping;

    public const NAME = 'business_status';

    public function defineName(): string
    {
        return self::NAME;
    }

    public function convertToRaw(mixed $value): int
    {
        return $value->toInt();
    }

    public function defineEmptyValueForPHP(mixed $value): Status
    {
        return Status::enable();
    }

    public function defineClass(): string
    {
        return Status::class;
    }

    public function convertFromRaw(mixed $value): Status
    {
        return Status::fromInt($value);
    }
}