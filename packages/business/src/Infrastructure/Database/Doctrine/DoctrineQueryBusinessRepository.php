<?php

namespace Derhub\Business\Infrastructure\Database\Doctrine;

use Derhub\Business\Services\BusinessQueryItemMapper;
use Derhub\Shared\Query\QueryItemMapper;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
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
    public function __construct(
        EntityManagerInterface $entityManager,
        BusinessQueryItemMapper $mapper
    ) {
        parent::__construct($entityManager, $mapper);
    }

    protected function getTableName(): string
    {
        return SharedValues::TABLE_NAME;
    }

    protected function getRepository(): EntityRepository
    {
        return $this->entityManager->getRepository(Business::class);
    }

}