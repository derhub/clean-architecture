<?php

namespace Derhub\Integration\ModuleService;

use Derhub\Shared\Module\ModuleInterface;
use Derhub\Shared\Module\ModuleRegistry;

interface ModuleService
{
    /**
     * Return true when module is stated
     * @return bool
     */
    public function isStarted(): bool;
    public function list(): ModuleRegistry;

    public function register(ModuleInterface ...$module): void;

    /**
     * Start all the registered module
     */
    public function start(): void;
}
