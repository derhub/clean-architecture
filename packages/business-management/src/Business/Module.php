<?php

namespace Derhub\BusinessManagement\Business;

use Derhub\Shared\Module\ModuleCapabilities;
use Derhub\Shared\Module\ModuleInterface;

final class Module implements ModuleInterface
{
    use ModuleCapabilities;

    public const ID = 'business';

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
            Services\TransferOwnership\TransferBusinessOwnership::class,
            Services\TransferOwnership\TransferBusinessOwnershipHandler::class,
        );

        /**
         * Queries
         */
        $this->addQuery(
            Services\BusinessList\BusinessList::class,
            Services\BusinessList\BusinessListHandler::class
        );
        $this->addQuery(
            Services\GetBusinessById\GetBusinessById::class,
            Services\GetBusinessById\GetBusinessByIdHandler::class
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
