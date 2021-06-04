<?php

namespace Derhub\BusinessManagement\Employee\Infrastructure\Database\Doctrine;

use Derhub\BusinessManagement\Employee\Infrastructure\Database\EmployeeQueryRepository;
use Derhub\BusinessManagement\Employee\Model\Employee;
use Derhub\BusinessManagement\Employee\Services\EmployeeQueryMapper;
use Derhub\BusinessManagement\Employee\Shared\EmployeeValues;
use Derhub\Shared\Database\Doctrine\DoctrineQueryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class DoctrineEmployeeQueryRepository extends DoctrineQueryRepository
    implements EmployeeQueryRepository
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);
        $this->mapper = new EmployeeQueryMapper();
    }

    protected function getRepository(): EntityRepository
    {
        return $this->entityManager->getRepository(Employee::class);
    }

    protected function getTableName(): string
    {
        return EmployeeValues::TABLE_NAME;
    }
}