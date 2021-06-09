<?php

declare(strict_types=1);

namespace Derhub\Integration\ModuleService;


use Derhub\Shared\Module\ModuleInterface;
use Derhub\Shared\Module\ModuleRegistry;

class ModuleListImpl implements ModuleRegistry
{
    /**
     * @var ModuleInterface[]
     */
    private array $modules;

    public function __construct()
    {
        $this->modules = [];
    }

    public function all(): array
    {
        return $this->modules;
    }

    public function get(string $id): ?ModuleInterface
    {
        if ($this->has($id)) {
            return $this->modules[$id];
        }

        return null;
    }

    public function has(string $id): bool
    {
        return isset($this->modules[$id]);
    }

    public function register(ModuleInterface ...$modules): void
    {
        foreach ($modules as $module) {
            if ($this->has($module->getId())) {
                throw ModuleAlreadyRegistered::withModule($module);
            }

            $this->modules[$module->getId()] = $module;
        }
    }
}
