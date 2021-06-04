<?php

namespace Derhub\BusinessManagement\Employee\Infrastructure\Database\Doctrine\Types;

use Derhub\BusinessManagement\Employee\Infrastructure\Database\Doctrine\DbTypeBytes;
use Derhub\BusinessManagement\Employee\Model\Values\EmployeeId;
use Doctrine\DBAL\Types\GuidType;

class EmployeeIdType extends GuidType
{
    use DbTypeBytes;

    public const NAME = 'business_employee_id';

    public function defineClass(): string
    {
        return EmployeeId::class;
    }

    public function defineName(): string
    {
        return self::NAME;
    }
}
