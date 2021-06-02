<?php

namespace Derhub\BusinessManagement\Business\Infrastructure\Database\Doctrine\Type;

use Derhub\Shared\Database\Doctrine\Types\DbalTyping;
use Doctrine\DBAL\Types\IntegerType;
use Derhub\BusinessManagement\Business\Model\Values\OnBoardStatus;

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
