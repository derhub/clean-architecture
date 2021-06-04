<?php

namespace Derhub\BusinessManagement\Employee;

use Derhub\BusinessManagement\Employee\Infrastructure;
use Derhub\BusinessManagement\Employee\Model;
use Derhub\BusinessManagement\Employee\Services;
use Derhub\Shared\Capabilities\ModuleCapabilities;
use Derhub\Shared\ModuleInterface;

class Module implements ModuleInterface
{
    use ModuleCapabilities;

    public const ID = 'employee';

    public function getId(): string
    {
        return self::ID;
    }

    public function start(): void
    {
        $this
            ->addDependency(
                Model\EmployeeRepository::class,
                Infrastructure\Database\EmployeePersistenceRepository::class,
            )
            ->addDependency(
                Infrastructure\Database\EmployeeQueryRepository::class,
                Infrastructure\Database\Doctrine\DoctrineEmployeeQueryRepository::class
            )
        ;

        $this->registerCommands();
        $this->registerQuery();
    }

    private function registerCommands(): void
    {
        $this->addCommand(
            Services\RegisterEmployee\RegisterEmployee::class,
            Services\RegisterEmployee\RegisterEmployeeHandler::class,
        )
            ->addCommand(
                Services\UpdateDetails\UpdateEmployeeDetails::class,
                Services\UpdateDetails\UpdateEmployeeDetailsHandler::class
            )
        ;
    }

    private function registerQuery(): void
    {
        $this->addQuery(
            Services\GetBusinessEmployees\GetBusinessEmployees::class,
            Services\GetBusinessEmployees\GetBusinessEmployeesHandler::class
        );
    }
}