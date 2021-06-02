<?php

namespace Derhub\BusinessManagement\Business\Infrastructure\Database\Doctrine;

use Derhub\BusinessManagement\Business\Services\BusinessQueryItemMapper;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Derhub\BusinessManagement\Business\Shared\SharedValues;
use Derhub\BusinessManagement\Business\Infrastructure\Database\QueryBusinessRepository;
use Derhub\BusinessManagement\Business\Model\Business;
use Derhub\Shared\Database\Doctrine\DoctrineQueryRepository;

/**
 * @template-extends AbstractDoctrineQueryRepository<Business>
 */
class DoctrineQueryBusinessRepository extends DoctrineQueryRepository implements QueryBusinessRepository
{
    public function __construct(
        EntityManagerInterface $entityManager,
        BusinessQueryItemMapper $mapper
    ) {
        parent::__construct($entityManager, $mapper);
    }

    protected function getRepository(): EntityRepository
    {
        return $this->entityManager->getRepository(Business::class);
    }

    protected function getTableName(): string
    {
        return SharedValues::TABLE_NAME;
    }
}
