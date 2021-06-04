<?php

namespace Derhub\BusinessManagement\Employee\Infrastructure\Database\Doctrine\Types;

use Derhub\BusinessManagement\Employee\Infrastructure\Database\Doctrine\DbTypeBytes;
use Derhub\BusinessManagement\Employee\Model\Values\Status;
use Doctrine\DBAL\Types\StringType;

class EmployeeStatusIdType implements StringType
{
    use DbTypeBytes;

    public const NAME = 'employee_status_id';

    public function defineClass(): string
    {
        return Status::class;
    }

    public function defineName(): string
    {
        return self::NAME;
    }
}