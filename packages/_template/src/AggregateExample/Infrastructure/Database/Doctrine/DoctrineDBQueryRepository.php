<?php

namespace Derhub\Template\AggregateExample\Infrastructure\Database\Doctrine;

use Derhub\Shared\Database\Doctrine\DoctrineQueryRepository;
use Derhub\Template\AggregateExample\Infrastructure\Database\DBQueryRepository;
use Derhub\Template\AggregateExample\Model\SampleModel;
use Derhub\Template\AggregateExample\Services\QueryResultMapper;
use Derhub\Template\AggregateExample\Shared\SharedValues;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class DoctrineDBQueryRepository extends DoctrineQueryRepository
    implements DBQueryRepository
{
    public function __construct(
        EntityManagerInterface $entityManager,
    ) {
        parent::__construct($entityManager);
        $this->setMapper(new QueryResultMapper());
    }

    protected function getRepository(): EntityRepository
    {
        return $this->entityManager->getRepository(SampleModel::class);
    }

    protected function getTableName(): string
    {
        return SharedValues::TABLE_NAME;
    }
}