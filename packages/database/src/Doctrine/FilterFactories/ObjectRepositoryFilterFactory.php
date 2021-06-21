<?php

namespace Derhub\Shared\Database\Doctrine\FilterFactories;

use Derhub\Shared\Database\Doctrine\Capabilities\FilterFactoryCapabilities;
use Doctrine\ORM\QueryBuilder;
use Derhub\Shared\Query\QueryFilter;
use Derhub\Shared\Query\QueryFilterFactory;
use Doctrine\Persistence\ObjectRepository;

/**
 * @template T
 */
class ObjectRepositoryFilterFactory implements QueryFilterFactory
{
    use FilterFactoryCapabilities;

    private const ALIAS = 'b';
    private QueryBuilder $queryBuilder;

    /**
     * @param \Doctrine\Persistence\ObjectRepository<T> $model
     */
    public function __construct(
        private ObjectRepository $model
    ) {
        $this->loopKey = 0;
        $this->queryBuilder = $this->model->createQueryBuilder(self::ALIAS);
    }

    public function createField(QueryFilter $filter): string
    {
        return self::ALIAS.'.'.$filter->field();
    }

    public function createLookupField(
        QueryFilter $filter,
    ): string {
        return $filter->field()[0].$this->loopKey;
    }

    public function getQueryBuilder(): QueryBuilder
    {
        return $this->queryBuilder;
    }
}
