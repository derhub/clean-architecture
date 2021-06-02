<?php

use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Dotenv\Dotenv;
use EB\Business\Infrastructure\Persistence\Doctrine\Type\BusinessIdType;
use EB\Business\Infrastructure\Persistence\Doctrine\Type\BusinessNameType;
use EB\Business\Infrastructure\Persistence\Doctrine\Type\BusinessOwnerIdType;
use Illuminate\Support\Env;
use Doctrine\Migrations\Tools\Console\Command;

require __DIR__.'/vendor/autoload.php';

/** @var \Illuminate\Foundation\Application $app */
$app = require __DIR__.'/bootstrap/app.php';

\Doctrine\DBAL\Types\Type::addType(
    BusinessIdType::NAME,
    BusinessIdType::class
);

\Doctrine\DBAL\Types\Type::addType(
    BusinessNameType::NAME,
    BusinessNameType::class
);

\Doctrine\DBAL\Types\Type::addType(
    BusinessOwnerIdType::NAME,
    BusinessOwnerIdType::class
);

\EB\Shared\Persistence\Doctrine\DoctrineFactory::registerDefaultTypes();

Dotenv::create(
    Env::getRepository(),
    $app->environmentPath(),
    $app->environmentFile()
)->safeLoad();

$config = require __DIR__.'/config/eb.doctrine_orm.php';

$entityManger = \EB\Shared\Persistence\Doctrine\DoctrineFactory::createEntityManager(
    $config
);

$migrationConfig = new \Doctrine\Migrations\Configuration\Migration\PhpFile(
    config_path('eb.doctrine_migration.php')
);
$dependencyFactory = DependencyFactory::fromEntityManager(
    $migrationConfig,
    new ExistingEntityManager(
        $entityManger
    )
);
$helper = ConsoleRunner::createHelperSet($entityManger);

$commands = [
    new Command\DumpSchemaCommand($dependencyFactory),
    new Command\ExecuteCommand($dependencyFactory),
    new Command\GenerateCommand($dependencyFactory),
    new Command\LatestCommand($dependencyFactory),
    new Command\ListCommand($dependencyFactory),
    new Command\MigrateCommand($dependencyFactory),
    new Command\RollupCommand($dependencyFactory),
    new Command\StatusCommand($dependencyFactory),
    new Command\SyncMetadataCommand($dependencyFactory),
    new Command\VersionCommand($dependencyFactory),
    new Command\UpToDateCommand($dependencyFactory),
    new Command\CurrentCommand($dependencyFactory),
];


ConsoleRunner::run($helper, $commands);
