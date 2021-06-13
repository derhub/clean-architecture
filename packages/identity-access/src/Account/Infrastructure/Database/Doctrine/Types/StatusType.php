<?php

namespace Derhub\IdentityAccess\Account\Infrastructure\Database\Doctrine\Types;

use Derhub\IdentityAccess\Account\Model\Values\Status;
use Derhub\Shared\Database\Doctrine\Types\DbalTyping;
use Doctrine\DBAL\Types\IntegerType;

class StatusType extends IntegerType
{
    use DbalTyping;

    public const NAME = 'user_account_status';

    public function convertFromRaw(mixed $value): mixed
    {
        return Status::fromInt($value);
    }

    public function convertToRaw(mixed $value): mixed
    {
        return $value->toInt();
    }

    public function defineClass(): string
    {
        return Status::class;
    }

    public function defineEmptyValueForPHP(mixed $value): mixed
    {
        return new Status();
    }

    public function defineEmptyValueForDB($value): mixed
    {
        return Status::activated()->toInt();
    }

    public function defineName(): string
    {
        return self::NAME;
    }
}