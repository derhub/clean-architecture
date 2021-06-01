<?php

namespace Derhub\Template\AggregateExample\Infrastructure\Database\Doctrine;

use Derhub\Template\AggregateExample\Infrastructure\Database\Doctrine\Type\TemplateIdType;
use Derhub\Template\AggregateExample\Infrastructure\Database\Doctrine\Type\TemplateNameType;
use Derhub\Template\AggregateExample\Infrastructure\Database\Doctrine\Type\TemplateStatusType;

class DoctrineTypings
{
    public static function register(): void
    {
        \Doctrine\DBAL\Types\Type::addType(
            TemplateIdType::NAME,
            TemplateIdType::class
        );

        \Doctrine\DBAL\Types\Type::addType(
            TemplateNameType::NAME,
            TemplateNameType::class
        );

        \Doctrine\DBAL\Types\Type::addType(
            TemplateStatusType::NAME,
            TemplateStatusType::class
        );
    }
}