<?php

namespace Derhub\Shared\Database\Doctrine\FilterFactories;

use Derhub\Shared\Database\Doctrine\Capabilities\FilterFactoryCapabilities;
use Derhub\Shared\Query\QueryFilter;
use Derhub\Shared\Query\QueryFilterFactory;
use Doctrine\DBAL\Query\QueryBuilder;

class DbalQueryBuilderFilterFactory implements QueryFilterFactory
{
    use FilterFactoryCapabilities;

    public function __construct(
        private QueryBuilder $queryBuilder,
        private ?string $tableAlias = null
    ) {
    }

    public function createField(QueryFilter|\Doctrine\DBAL\Query\QueryBuilder $filter): string
    {
        $alias = '';
        if ($this->tableAlias) {
            $alias = $this->tableAlias.'.';
        }

        return $alias.$filter->field();
    }

    public function createLookupField(
        QueryFilter|\Doctrine\DBAL\Query\QueryBuilder $filter,
    ): string {
        return $filter->field()[0].$this->loopKey;
    }

    public function getQueryBuilder(
    ): \Doctrine\ORM\QueryBuilder|\Doctrine\DBAL\Query\QueryBuilder {
        return $this->queryBuilder;
    }
}
