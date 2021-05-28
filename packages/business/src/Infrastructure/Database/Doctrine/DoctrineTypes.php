<?php

namespace Derhub\Business\Infrastructure\Database\Doctrine;

use Derhub\Business\Infrastructure\Persistence\Doctrine\Type\BusinessCountryType;
use Derhub\Business\Infrastructure\Persistence\Doctrine\Type\BusinessOnBoardStatusType;
use Derhub\Business\Infrastructure\Persistence\Doctrine\Type\BusinessIdType;
use Derhub\Business\Infrastructure\Persistence\Doctrine\Type\BusinessNameType;
use Derhub\Business\Infrastructure\Persistence\Doctrine\Type\BusinessOwnerIdType;
use Derhub\Business\Infrastructure\Persistence\Doctrine\Type\BusinessSlugType;
use Derhub\Business\Infrastructure\Persistence\Doctrine\Type\BusinessStatusType;

class DoctrineTypes
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