<?php

namespace Derhub\Business;

use Derhub\Business\Model\Event\BusinessCountryChanged;
use Derhub\Business\Model\Event\BusinessDisabled;
use Derhub\Business\Model\Event\BusinessEnabled;
use Derhub\Business\Model\Event\BusinessHanded;
use Derhub\Business\Model\Event\BusinessNameChanged;
use Derhub\Business\Model\Event\BusinessOnboarded;
use Derhub\Business\Model\Event\BusinessOwnershipTransferred;
use Derhub\Business\Model\Event\BusinessSlugChanged;
use Derhub\Business\Process\BusinessEnabledReact;
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

    public function getId(): string
    {
        return self::ID;
    }

    public function start(): void
    {
    }

    public function getServices(): array
    {
        return [
            'commands' => [
                OnBoardBusiness::class => OnBoardBusinessHandler::class,
                DisableBusiness::class => DisableBusinessHandler::class,
                EnableBusiness::class => EnableBusinessHandler::class,
                TransferBusinessesOwnership::class => TransferBusinessesOwnershipHandler::class,
            ],
            'queries' => [
                GetBusinesses::class => GetBusinessesHandler::class,
                GetByAggregateId::class => GetByAggregateIdHandler::class,
            ],
            'events' => [
                BusinessCountryChanged::class,
                BusinessDisabled::class,
                BusinessEnabled::class,
                BusinessHanded::class,
                BusinessNameChanged::class,
                BusinessOnboarded::class,
                BusinessOwnershipTransferred::class,
                BusinessSlugChanged::class,
            ],
            'listeners' => [
                self::ID.'.event.BusinessEnabled' => [
                    BusinessEnabledReact::class
                ]
            ]
        ];
    }
}
