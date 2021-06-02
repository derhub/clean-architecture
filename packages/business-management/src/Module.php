<?php

namespace Derhub\BusinessManagement;

use Derhub\BusinessManagement\Business\BusinessModule;
use Derhub\Shared\Capabilities\ModuleCapabilities;
use Derhub\Shared\ModuleInterface;

class Module implements ModuleInterface
{
    use ModuleCapabilities;

    public const ID = 'business_management';
    /**
     * @var \Derhub\BusinessManagement\Business\BusinessModule
     */
    private BusinessModule $business;

    public function __construct()
    {
        $this->business = new BusinessModule($this);
    }

    public function getId(): string
    {
        return self::ID;
    }

    public function start(): void
    {
        $this->business->start();
    }
}
