<?php

namespace Derhub\Laravel\BusinessManagement;

use Derhub\BusinessManagement\Business\Infrastructure\Database\Doctrine\BusinessDoctrineTypes;
use Derhub\BusinessManagement\Employee\Infrastructure\Database\Doctrine\EmployeeDoctrineTypes;
use Derhub\Shared\Database\Doctrine\DoctrineXmlMetadataRegistry;

class BMServiceProvider
    extends \Illuminate\Support\ServiceProvider
{
    public function register(): void
    {
        DoctrineXmlMetadataRegistry::addPath(
            __DIR__.'/../../../configs/mapping'
        );

        BusinessDoctrineTypes::register();
        EmployeeDoctrineTypes::register();
    }
}