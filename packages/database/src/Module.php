<?php

namespace Derhub\Shared\Database;

use Derhub\Shared\Capabilities\ModuleCapabilities;
use Derhub\Shared\Database\Doctrine\DoctrinePersistenceRepository;
use Derhub\Shared\ModuleInterface;
use Derhub\Shared\Persistence\DatabasePersistenceRepository;

class Module implements ModuleInterface
{
    public const ID = 'module_database';

    use ModuleCapabilities;

    public function getId(): string
    {
        return self::ID;
    }

    public function start(): void
    {
        $this->addDependency(
            DatabasePersistenceRepository::class,
            DoctrinePersistenceRepository::class
        );
    }
}