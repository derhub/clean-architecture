<?php
/**
 * Include this file will be called on app bootstrap
 * @var \Derhub\Shared\Container\ContainerInterface $container
 */

use Derhub\Shared\Database\Doctrine\DatabaseDoctrineTypes;

DatabaseDoctrineTypes::register();

$container->bind(
    \Derhub\Shared\Persistence\DatabasePersistenceRepository::class,
    \Derhub\Shared\Database\Doctrine\DoctrinePersistenceRepository::class
);

$container->bind(
    \Derhub\Shared\Database\DBTransaction::class,
    \Derhub\Shared\Database\Doctrine\DoctrineDBTransaction::class
);
