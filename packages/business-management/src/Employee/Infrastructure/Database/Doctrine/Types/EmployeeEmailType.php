<?php

namespace Derhub\BusinessManagement\Employee\Infrastructure\Database\Doctrine\Types;

use Derhub\BusinessManagement\Employee\Infrastructure\Database\Doctrine\DbTypeBytes;
use Derhub\BusinessManagement\Employee\Model\Values\Email;
use Doctrine\DBAL\Types\StringType;

class EmployeeEmailType extends StringType
{
    use DbTypeBytes;

    public const NAME = 'employee_email';

    public function defineClass(): string
    {
        return Email::class;
    }

    public function defineName(): string
    {
        return self::NAME;
    }
}