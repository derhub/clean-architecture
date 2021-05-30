<?php

namespace Derhub\Template\Infrastructure\Database\Doctrine;

use Derhub\Template\Infrastructure\Database\Doctrine\Type\TemplateIdType;
use Derhub\Template\Infrastructure\Database\Doctrine\Type\TemplateNameType;

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
    }
}