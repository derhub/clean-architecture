<?php

namespace Derhub\Business;

use Derhub\Business\Infrastructure\Database\BusinessPersistenceRepository;
use Derhub\Business\Infrastructure\Database\Doctrine\DoctrineQueryBusinessRepository;
use Derhub\Business\Infrastructure\Database\QueryBusinessRepository;
use Derhub\Business\Infrastructure\Specifications\Doctrine\QueryUniqueNameSpec;
use Derhub\Business\Infrastructure\Specifications\Doctrine\QueryUniqueSlugSpec;
use Derhub\Business\Model\BusinessRepository;
use Derhub\Business\Model\Event\BusinessCountryChanged;
use Derhub\Business\Model\Event\BusinessDisabled;
use Derhub\Business\Model\Event\BusinessEnabled;
use Derhub\Business\Model\Event\BusinessHanded;
use Derhub\Business\Model\Event\BusinessNameChanged;
use Derhub\Business\Model\Event\BusinessOnboarded;
use Derhub\Business\Model\Event\BusinessOwnershipTransferred;
use Derhub\Business\Model\Event\BusinessSlugChanged;
use Derhub\Business\Model\Specification\UniqueNameSpec;
use Derhub\Business\Model\Specification\UniqueSlugSpec;
use Derhub\Business\Process\BusinessEnabledReact;
use Derhub\Business\Services\BusinessItemMapperDoctrine;
use Derhub\Business\Services\BusinessQueryItemMapper;
use Derhub\Business\Services\GetByAggregateId\GetByAggregateId;
use Derhub\Business\Services\GetByAggregateId\GetByAggregateIdHandler;
use Derhub\Business\Services\Disable\DisableBusiness;
use Derhub\Business\Services\Disable\DisableBusinessHandler;
use Derhub\Business\Services\Enable\EnableBusiness;
use Derhub\Business\Services\Enable\EnableBusinessHandler;
use Derhub\Business\Services\Onboard\OnBoardBusiness;
use Derhub\Business\Services\Onboard\OnBoardBusinessHandler;
use Derhub\Business\Services\GetBusinesses\GetBusinesses;
use Derhub\Business\Services\GetBusinesses\GetBusinessesHandler;
use Derhub\Business\Services\TransferOwnership\TransferBusinessesOwnership;
use Derhub\Business\Services\TransferOwnership\TransferBusinessesOwnershipHandler;
use Derhub\Shared\ModuleInterface;

final class Module implements ModuleInterface
{
    public const ID = 'business';
    public static ?array $services = null;

    public function __construct()
    {
    }

    public function getId(): string
    {
        return self::ID;
    }

    public function services(): array
    {
        return self::$services ??= [
            self::DEPENDENCY_SINGLETON => [
            ],
            self::DEPENDENCY_BIND => [
                // database
                BusinessQueryItemMapper::class => BusinessItemMapperDoctrine::class,
                BusinessRepository::class => BusinessPersistenceRepository::class,
                QueryBusinessRepository::class => DoctrineQueryBusinessRepository::class,

                // specification
                UniqueNameSpec::class => QueryUniqueNameSpec::class,
                UniqueSlugSpec::class => QueryUniqueSlugSpec::class,

            ],
            self::SERVICE_COMMANDS => [
                OnBoardBusiness::class => OnBoardBusinessHandler::class,
                DisableBusiness::class => DisableBusinessHandler::class,
                EnableBusiness::class => EnableBusinessHandler::class,
                TransferBusinessesOwnership::class => TransferBusinessesOwnershipHandler::class,
            ],
            self::SERVICE_QUERIES => [
                GetBusinesses::class => GetBusinessesHandler::class,
                GetByAggregateId::class => GetByAggregateIdHandler::class,
            ],
            self::SERVICE_EVENTS => [
                BusinessCountryChanged::class,
                BusinessDisabled::class,
                BusinessEnabled::class,
                BusinessHanded::class,
                BusinessNameChanged::class,
                BusinessOnboarded::class,
                BusinessOwnershipTransferred::class,
                BusinessSlugChanged::class,
            ],
            self::SERVICE_LISTENERS => [
                self::ID.'.event.BusinessEnabled' => [
                    BusinessEnabledReact::class,
                ],
            ],
        ];
    }

    public function start(): void
    {
    }
}
