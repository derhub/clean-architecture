<?php

namespace Derhub\Business\Infrastructure\Persistence\Doctrine\Type;

use Doctrine\DBAL\Types\IntegerType;
use Derhub\Business\Model\Values\OnBoardStatus;
use Derhub\Shared\Persistence\Doctrine\Types\DbalTyping;

class BusinessOnBoardStatusType extends IntegerType
{
    use DbalTyping;

    public const NAME = 'business_onboard_status';

    public function defineName(): string
    {
        return self::NAME;
    }

    public function defineEmptyValueForPHP(mixed $value): OnBoardStatus
    {
        return OnBoardStatus::notHanded();
    }

    public function defineClass(): string
    {
        return OnBoardStatus::class;
    }

    public function convertToRaw(mixed $value): int
    {
        return $value->toInt();
    }

    public function convertFromRaw(mixed $value): OnBoardStatus
    {
        return OnBoardStatus::fromInt($value);
    }
}