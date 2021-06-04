<?php

namespace Derhub\BusinessManagement\Employee;


use Derhub\BusinessManagement\Employee\Infrastructure\Database\Doctrine\DoctrineEmployeeQueryRepository;
use Derhub\BusinessManagement\Employee\Infrastructure\Database\EmployeePersistenceRepository;
use Derhub\BusinessManagement\Employee\Infrastructure\Database\EmployeeQueryRepository;
use Derhub\BusinessManagement\Employee\Model\EmployeeRepository;
use Derhub\BusinessManagement\Employee\Services\GetBusinessEmployees\GetBusinessEmployees;
use Derhub\BusinessManagement\Employee\Services\GetBusinessEmployees\GetBusinessEmployeesHandler;
use Derhub\BusinessManagement\Employee\Services\NewEmployee\NewEmployee;
use Derhub\BusinessManagement\Employee\Services\NewEmployee\NewEmployeeHandler;
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
                EmployeeRepository::class,
                EmployeePersistenceRepository::class,
            )
            ->addDependency(
                EmployeeQueryRepository::class,
                DoctrineEmployeeQueryRepository::class
            )
        ;

        $this->registerCommands();
        $this->registerQuery();
    }

    private function registerCommands(): void
    {
        $this->addCommand(
            NewEmployee::class,
            NewEmployeeHandler::class,
        );
    }

    private function registerQuery(): void
    {
        $this->addQuery(
            GetBusinessEmployees::class,
            GetBusinessEmployeesHandler::class
        );
    }
}