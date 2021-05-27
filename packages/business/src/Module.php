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
use Derhub\Business\Services\FindByAggregateId\FindByAggregateId;
use Derhub\Business\Services\FindByAggregateId\FindByAggregateIdHandler;
use Derhub\Business\Services\Disable\DisableBusiness;
use Derhub\Business\Services\Disable\DisableBusinessHandler;
use Derhub\Business\Services\Enable\EnableBusiness;
use Derhub\Business\Services\Enable\EnableBusinessHandler;
use Derhub\Business\Services\HandOver\HandOverBusiness;
use Derhub\Business\Services\HandOver\HandOverBusinessHandler;
use Derhub\Business\Services\Onboard\OnBoardBusiness;
use Derhub\Business\Services\Onboard\OnBoardBusinessHandler;
use Derhub\Business\Services\BusinessList\BusinessList;
use Derhub\Business\Services\BusinessList\BusinessListHandler;
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
                HandOverBusiness::class => HandOverBusinessHandler::class,
                OnBoardBusiness::class => OnBoardBusinessHandler::class,
                DisableBusiness::class => DisableBusinessHandler::class,
                EnableBusiness::class => EnableBusinessHandler::class,
                TransferBusinessesOwnership::class => TransferBusinessesOwnershipHandler::class,
            ],
            'queries' => [
                BusinessList::class => BusinessListHandler::class,
                FindByAggregateId::class => FindByAggregateIdHandler::class,
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
