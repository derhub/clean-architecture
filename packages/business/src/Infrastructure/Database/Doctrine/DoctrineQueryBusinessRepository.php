<?php

namespace Derhub\Business\Infrastructure\Database\Doctrine;

use Doctrine\Persistence\ObjectRepository;
use Derhub\Business\Shared\SharedValues;
use Derhub\Business\Infrastructure\Database\QueryBusinessRepository;
use Derhub\Business\Model\Business;
use Derhub\Shared\Database\Doctrine\DoctrineQueryRepository;

/**
 * @template-extends AbstractDoctrineQueryRepository<Business>
 */
class DoctrineQueryBusinessRepository extends DoctrineQueryRepository
    implements QueryBusinessRepository
{
    protected function getRepository(): ObjectRepository
    {
        return $this->entityManager->getRepository(Business::class);
    }

    protected function getTableName(): string
    {
        return SharedValues::TABLE_NAME;
    }
}