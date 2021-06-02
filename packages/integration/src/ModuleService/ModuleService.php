<?php

namespace Derhub\Integration\ModuleService;

use Derhub\Shared\ModuleInterface;

interface ModuleService
{
    /**
     * Return true when module is stated
     * @return bool
     */
    public function isStarted(): bool;
    public function list(): ModuleList;

    public function register(ModuleInterface ...$module): void;

    /**
     * Start all the registered module
     */
    public function start(): void;
}
