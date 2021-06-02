<?php

namespace Derhub\Integration\ModuleService;

use Derhub\Shared\ModuleInterface;

interface ModuleList
{
    public function all(): array;

    public function get(string $id): ?ModuleInterface;

    public function has(string $id): bool;
    /**
     * @throws \Derhub\Integration\ModuleService\ModuleAlreadyRegistered
     */
    public function register(ModuleInterface ...$module): void;
}
