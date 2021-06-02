<?php

namespace Derhub\BusinessManagement\Business;

use Derhub\Shared\Capabilities\ModuleCapabilities;
use Derhub\Shared\ModuleInterface;

final class Module implements ModuleInterface
{
    use ModuleCapabilities;

    public const ID = 'business-management';

    public function getId(): string
    {
        return self::ID;
    }

    public function start(): void
    {
        $this->addDependency(
            Services\BusinessQueryItemMapper::class,
            Services\BusinessItemMapperDoctrine::class
        );
        $this->addDependency(
            Model\BusinessRepository::class,
            Infrastructure\Database\BusinessPersistenceRepository::class,
        );
        $this->addDependency(
            Infrastructure\Database\QueryBusinessRepository::class,
            Infrastructure\Database\Doctrine\DoctrineQueryBusinessRepository::class,
        );
        $this->addDependency(
            Model\Specification\UniqueSlugSpec::class,
            Infrastructure\Specifications\QueryUniqueSlugSpec::class,
        );
        $this->addDependency(
            Model\Specification\UniqueNameSpec::class,
            Infrastructure\Specifications\QueryUniqueNameSpec::class,
        );

        /**
         * Commands
         */
        $this->addCommand(
            Services\Disable\DisableBusiness::class,
            Services\Disable\DisableBusinessHandler::class
        );
        $this->addCommand(
            Services\Enable\EnableBusiness::class,
            Services\Enable\EnableBusinessHandler::class
        );
        $this->addCommand(
            Services\Onboard\OnBoardBusiness::class,
            Services\Onboard\OnBoardBusinessHandler::class
        );
        $this->addCommand(
            Services\TransferOwnership\TransferBusinessesOwnership::class,
            Services\TransferOwnership\TransferBusinessesOwnershipHandler::class,
        );

        /**
         * Queries
         */
        $this->addQuery(
            Services\GetBusinesses\GetBusinesses::class,
            Services\GetBusinesses\GetBusinessesHandler::class
        );
        $this->addQuery(
            Services\GetByAggregateId\GetByAggregateId::class,
            Services\GetByAggregateId\GetByAggregateIdHandler::class
        );

        /**
         * Commands
         */
        $this->addEvent(
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
