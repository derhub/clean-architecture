<?php

namespace Derhub\Shared\Module;

interface ModuleRegistry
{
    public function all(): array;

    public function get(string $id): ?ModuleInterface;

    public function has(string $id): bool;

    /**
     * @throw \Derhub\Shared\Module\ModuleAlreadyRegistered
     */
    public function register(ModuleInterface ...$module): void;
}