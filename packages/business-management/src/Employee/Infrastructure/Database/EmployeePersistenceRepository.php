<?php

namespace Derhub\BusinessManagement\Employee\Infrastructure\Database;

use Derhub\BusinessManagement\Employee\Model\Employee;
use Derhub\BusinessManagement\Employee\Model\EmployeeRepository;
use Derhub\BusinessManagement\Employee\Model\Values\EmployeeId;
use Derhub\Shared\Model\AggregateRoot;
use Derhub\Shared\Model\AggregateRootId;
use Derhub\Shared\Persistence\DatabasePersistenceRepository;

class EmployeePersistenceRepository implements EmployeeRepository
{
    public function __construct(private DatabasePersistenceRepository $repo)
    {
        $this->repo->setAggregateClass(Employee::class);
    }

    public function get(AggregateRootId $id): Employee
    {
        return $this->repo->findById($id->toString());
    }

    public function getNextId(): EmployeeId
    {
        return EmployeeId::generate();
    }

    public function save(AggregateRoot $aggregateRoot): void
    {
        $this->repo->persist($aggregateRoot);
    }
}