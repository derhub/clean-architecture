<?php

namespace Derhub\BusinessManagement\Employee\Infrastructure\Database\Doctrine\Types;

use Derhub\BusinessManagement\Employee\Infrastructure\Database\Doctrine\DbTypeBytes;
use Derhub\BusinessManagement\Employee\Model\Values\EmployeePosition;
use Derhub\Shared\Database\Doctrine\Types\DbalTyping;
use Doctrine\DBAL\Types\StringType;

class EmployeePositionType extends StringType
{
    use DbTypeBytes;

    public const NAME = 'employee_position';

    public function defineClass(): string
    {
        return EmployeePosition::class;
    }

    public function defineName(): string
    {
        return self::NAME;
    }
}