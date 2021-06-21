<?php

namespace Derhub\Shared\Database\Doctrine\Capabilities;

use Derhub\Shared\Query\Filters\InArrayFilter;
use Derhub\Shared\Query\Filters\OperationFilter;
use Derhub\Shared\Query\Filters\PaginationFilter;
use Derhub\Shared\Query\Filters\RangeFilter;
use Derhub\Shared\Query\Filters\SearchFilter;
use Derhub\Shared\Query\Filters\SortFilter;
use Derhub\Shared\Query\QueryFilter;
use Doctrine\ORM\QueryBuilder;

trait FilterFactoryCapabilities
{
    private mixed $loopKey;

    protected function setLoopKey(string|int $key): void
    {
        $this->loopKey = $key;
    }

    abstract protected function getQueryBuilder(
    ): \Doctrine\ORM\QueryBuilder|\Doctrine\DBAL\Query\QueryBuilder;

    abstract public function createField(
        QueryFilter|\Doctrine\DBAL\Query\QueryBuilder $filter
    ): string;

    abstract public function createLookupField(
        QueryFilter|\Doctrine\DBAL\Query\QueryBuilder $filter
    ): string;

    public function create(
        mixed $id,
        QueryFilter|\Doctrine\DBAL\Query\QueryBuilder $filter
    ): \Doctrine\ORM\QueryBuilder|\Doctrine\DBAL\Query\QueryBuilder {
        $this->loopKey = $id;

        return match (true) {
            $filter instanceof SearchFilter => $this->createForSearch(
                $this->getQueryBuilder(),
                $filter
            ),
            $filter instanceof OperationFilter => $this->createForOperation(
                $this->getQueryBuilder(),
                $filter
            ),
            $filter instanceof PaginationFilter => $this->createForPagination(
                $this->getQueryBuilder(),
                $filter
            ),
            $filter instanceof RangeFilter => $this->createForRange(
                $this->getQueryBuilder(),
                $filter
            ),
            $filter instanceof SortFilter => $this->createForSort(
                $this->getQueryBuilder(),
                $filter
            ),
            $filter instanceof InArrayFilter => $this->createForInArray(
                $this->getQueryBuilder(),
                $filter
            ),
            default => $this->getQueryBuilder(),
        };
    }

    public function createForInArray(
        QueryBuilder|\Doctrine\DBAL\Query\QueryBuilder $queryBuilder,
        InArrayFilter $filter
    ): QueryBuilder|\Doctrine\DBAL\Query\QueryBuilder {
        $symbol = $filter->operation();
        $lookupField = $this->createLookupField($filter);

        return $queryBuilder
            ->where(
                "{$this->createField($filter)} $symbol (:$lookupField)"
            )
            ->setParameter($lookupField, $filter->value())
            ;
    }

    public function createForOperation(
        QueryBuilder|\Doctrine\DBAL\Query\QueryBuilder $queryBuilder,
        OperationFilter $filter
    ): QueryBuilder|\Doctrine\DBAL\Query\QueryBuilder {
        $symbol = $filter->operationSymbol();
        $lookupField = $this->createLookupField($filter);

        return $queryBuilder
            ->where(
                "{$this->createField($filter)} $symbol :$lookupField"
            )
            ->setParameter($lookupField, $filter->value())
            ;
    }

    public function createForPagination(
        QueryBuilder|\Doctrine\DBAL\Query\QueryBuilder $queryBuilder,
        PaginationFilter $filter
    ): QueryBuilder|\Doctrine\DBAL\Query\QueryBuilder {
        return $queryBuilder
            ->setFirstResult($filter->page())
            ->setMaxResults($filter->perPage())
            ;
    }

    public function createForRange(
        QueryBuilder|\Doctrine\DBAL\Query\QueryBuilder $queryBuilder,
        RangeFilter $filter
    ): QueryBuilder|\Doctrine\DBAL\Query\QueryBuilder {
        $symbol = $filter->operationSymbol();
        $lookupField = $this->createLookupField($filter);

        return $queryBuilder
            ->where(
                "{$this->createField($filter)} >$symbol :min$lookupField"
            )
            ->setParameter(
                "min$lookupField",
                $filter->minValue()
            )
            ->where(
                "{$this->createField($filter)} <$symbol :max$lookupField"
            )
            ->setParameter(
                "max$lookupField",
                $filter->maxValue()
            )
            ;
    }

    public function createForSearch(
        QueryBuilder|\Doctrine\DBAL\Query\QueryBuilder $queryBuilder,
        SearchFilter $filter
    ): QueryBuilder|\Doctrine\DBAL\Query\QueryBuilder {
        $lookupField = $this->createLookupField($filter);

        return $queryBuilder
            ->where(
                "{$this->createField($filter)} LIKE :$lookupField"
            )
            ->setParameter(
                $lookupField,
                "%{$filter->value()}%"
            )
            ;
    }

    public function createForSort(
        QueryBuilder|\Doctrine\DBAL\Query\QueryBuilder $queryBuilder,
        SortFilter $filter
    ): QueryBuilder {
        return $queryBuilder
            ->addOrderBy(
                $this->createField($filter),
                $filter->value()
            )
        ;
    }
}
