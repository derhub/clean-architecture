<?php

namespace Derhub\BusinessManagement\Business\Infrastructure\Database\Doctrine;

use Derhub\BusinessManagement\Business\Infrastructure\Database\Doctrine\Type\BusinessCountryType;
use Derhub\BusinessManagement\Business\Infrastructure\Database\Doctrine\Type\BusinessIdType;
use Derhub\BusinessManagement\Business\Infrastructure\Database\Doctrine\Type\BusinessNameType;
use Derhub\BusinessManagement\Business\Infrastructure\Database\Doctrine\Type\BusinessOnBoardStatusType;
use Derhub\BusinessManagement\Business\Infrastructure\Database\Doctrine\Type\BusinessOwnerIdType;
use Derhub\BusinessManagement\Business\Infrastructure\Database\Doctrine\Type\BusinessSlugType;
use Derhub\BusinessManagement\Business\Infrastructure\Database\Doctrine\Type\BusinessStatusType;

class BusinessDoctrineTypes
{
    public static function register(): void
    {
        \Doctrine\DBAL\Types\Type::addType(
            BusinessIdType::NAME,
            BusinessIdType::class
        );

        \Doctrine\DBAL\Types\Type::addType(
            BusinessNameType::NAME,
            BusinessNameType::class
        );

        \Doctrine\DBAL\Types\Type::addType(
            BusinessOwnerIdType::NAME,
            BusinessOwnerIdType::class
        );

        \Doctrine\DBAL\Types\Type::addType(
            BusinessStatusType::NAME,
            BusinessStatusType::class
        );

        \Doctrine\DBAL\Types\Type::addType(
            BusinessSlugType::NAME,
            BusinessSlugType::class
        );

        \Doctrine\DBAL\Types\Type::addType(
            BusinessOnBoardStatusType::NAME,
            BusinessOnBoardStatusType::class
        );

        \Doctrine\DBAL\Types\Type::addType(
            BusinessCountryType::NAME,
            BusinessCountryType::class
        );
    }
}