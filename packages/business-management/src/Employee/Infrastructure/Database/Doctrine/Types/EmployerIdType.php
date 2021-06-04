<?php

namespace Derhub\BusinessManagement\Employee\Infrastructure\Database\Doctrine\Types;

use Derhub\BusinessManagement\Employee\Infrastructure\Database\Doctrine\DbTypeBytes;
use Derhub\BusinessManagement\Employee\Model\Values\EmployerId;
use Doctrine\DBAL\Types\StringType;

class EmployerIdType extends StringType
{
    use DbTypeBytes;

    public const NAME = 'employee_employer_id';

    public function defineClass(): string
    {
        return EmployerId::class;
    }

    public function defineName(): string
    {
        return self::NAME;
    }
}