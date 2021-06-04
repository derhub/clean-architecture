<?php

namespace Derhub\BusinessManagement\Employee\Infrastructure\Database\Doctrine;

use Derhub\BusinessManagement\Employee\Infrastructure\Database\Doctrine\Types\EmployeeEmailType;
use Derhub\BusinessManagement\Employee\Infrastructure\Database\Doctrine\Types\EmployeeIdType;
use Derhub\BusinessManagement\Employee\Infrastructure\Database\Doctrine\Types\EmployeePositionType;
use Derhub\BusinessManagement\Employee\Infrastructure\Database\Doctrine\Types\EmployeeStatusIdType;
use Derhub\BusinessManagement\Employee\Infrastructure\Database\Doctrine\Types\EmployerIdType;
use Doctrine\DBAL\Types\Type;

class EmployeeDoctrineTypes
{
    public static function register(): void
    {
        Type::addType(EmployeeEmailType::NAME, EmployeeEmailType::class);
        Type::addType(EmployeePositionType::NAME, EmployeePositionType::class);
        Type::addType(EmployeeIdType::NAME, EmployeeIdType::class);
        Type::addType(EmployerIdType::NAME, EmployerIdType::class);
        Type::addType(EmployeeStatusIdType::NAME, EmployeeStatusIdType::class);
    }
}