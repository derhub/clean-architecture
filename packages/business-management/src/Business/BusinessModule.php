<?php

namespace Derhub\BusinessManagement\Business;

use Derhub\BusinessManagement\Module;

final class BusinessModule
{
    public function __construct(private Module $module)
    {
    }

    public function start(): void
    {
        $this->module->addDependency(
            Services\BusinessQueryItemMapper::class,
            Services\BusinessItemMapperDoctrine::class
        );
        $this->module->addDependency(
            Model\BusinessRepository::class,
            Infrastructure\Database\BusinessPersistenceRepository::class,
        );
        $this->module->addDependency(
            Infrastructure\Database\QueryBusinessRepository::class,
            Infrastructure\Database\Doctrine\DoctrineQueryBusinessRepository::class,
        );
        $this->module->addDependency(
            Model\Specification\UniqueSlugSpec::class,
            Infrastructure\Specifications\QueryUniqueSlugSpec::class,
        );
        $this->module->addDependency(
            Model\Specification\UniqueNameSpec::class,
            Infrastructure\Specifications\QueryUniqueNameSpec::class,
        );

        /**
         * Commands
         */
        $this->module->addCommand(
            Services\Disable\DisableBusiness::class,
            Services\Disable\DisableBusinessHandler::class
        );
        $this->module->addCommand(
            Services\Enable\EnableBusiness::class,
            Services\Enable\EnableBusinessHandler::class
        );
        $this->module->addCommand(
            Services\Onboard\OnBoardBusiness::class,
            Services\Onboard\OnBoardBusinessHandler::class
        );
        $this->module->addCommand(
            Services\TransferOwnership\TransferBusinessesOwnership::class,
            Services\TransferOwnership\TransferBusinessesOwnershipHandler::class,
        );

        /**
         * Queries
         */
        $this->module->addQuery(
            Services\GetBusinesses\GetBusinesses::class,
            Services\GetBusinesses\GetBusinessesHandler::class
        );
        $this->module->addQuery(
            Services\GetByAggregateId\GetByAggregateId::class,
            Services\GetByAggregateId\GetByAggregateIdHandler::class
        );

        /**
         * Commands
         */
        $this->module->addEvent(
            Model\Event\BusinessCountryChanged::class,
            Model\Event\BusinessDisabled::class,
            Model\Event\BusinessEnabled::class,
            Model\Event\BusinessHanded::class,
            Model\Event\BusinessNameChanged::class,
            Model\Event\BusinessOnboarded::class,
            Model\Event\BusinessOwnershipTransferred::class,
            Model\Event\BusinessSlugChanged::class,
        );
    }
}
