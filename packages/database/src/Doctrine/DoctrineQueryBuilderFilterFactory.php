<?php

namespace Derhub\Shared\Database\Doctrine;

use Doctrine\ORM\QueryBuilder;
use Derhub\Shared\Query\Filters\InArrayFilter;
use Derhub\Shared\Query\Filters\OperationFilter;
use Derhub\Shared\Query\Filters\PaginationFilter;
use Derhub\Shared\Query\Filters\RangeFilter;
use Derhub\Shared\Query\Filters\SearchFilter;
use Derhub\Shared\Query\Filters\SortFilter;
use Derhub\Shared\Query\QueryFilter;
use Derhub\Shared\Query\QueryFilterFactory;
use Doctrine\Persistence\ObjectRepository;

/**
 * @template T
 */
class DoctrineQueryBuilderFilterFactory implements QueryFilterFactory
{
    private QueryBuilder $queryBuilder;

    private const ALIAS = 'b';
    private int $loopKey;

    /**
     * @param \Doctrine\Persistence\ObjectRepository<T> $model
     */
    public function __construct(
        private ObjectRepository $model
    ) {
        $this->loopKey = 0;
        $this->queryBuilder = $this->model->createQueryBuilder(self::ALIAS);
    }

    public function create(mixed $id, QueryFilter $filter): QueryBuilder
    {
        $this->loopKey = $id;

        return match (true) {
            $filter instanceof SearchFilter => $this->createForSearch(
                $this->queryBuilder,
                $filter
            ),
            $filter instanceof OperationFilter => $this->createForOperation(
                $this->queryBuilder,
                $filter
            ),
            $filter instanceof PaginationFilter => $this->createForPagination(
                $this->queryBuilder,
                $filter
            ),
            $filter instanceof RangeFilter => $this->createForRange(
                $this->queryBuilder,
                $filter
            ),
            $filter instanceof SortFilter => $this->createForSort(
                $this->queryBuilder,
                $filter
            ),
            $filter instanceof InArrayFilter => $this->createForInArray(
                $this->queryBuilder,
                $filter
            ),
            default => $this->queryBuilder,
        };
    }
    public function createForInArray(
        QueryBuilder $queryBuilder,
        InArrayFilter $filter
    ): QueryBuilder {
        $symbol = $filter->operation();
        $lookupField = $this->createLookupField($filter);
        return $queryBuilder
            ->where(
                "{$this->createField($filter)} $symbol (:$lookupField)"
            )
            ->setParameter(
                $lookupField,
                $filter->value(),
//                \Doctrine\DBAL\Connection::PARAM_STR_ARRAY
            )
            ;
    }

    public function createForSearch(
        QueryBuilder $queryBuilder,
        SearchFilter $filter
    ): QueryBuilder {
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

    public function createForOperation(
        QueryBuilder $queryBuilder,
        OperationFilter $filter
    ): QueryBuilder {
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
        QueryBuilder $queryBuilder,
        PaginationFilter $filter
    ): QueryBuilder {
        return $queryBuilder
            ->setFirstResult($filter->page())
            ->setMaxResults($filter->perPage())
            ;
    }

    public function createForRange(
        QueryBuilder $queryBuilder,
        RangeFilter $filter
    ): QueryBuilder {
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

    public function createForSort(
        QueryBuilder $queryBuilder,
        SortFilter $filter
    ): QueryBuilder {
        return $queryBuilder
            ->addOrderBy($this->createField($filter), $filter->value())
        ;
    }

    public function createField(QueryFilter $filter): string
    {
        return self::ALIAS.'.'.$filter->field();
    }

    public function createLookupField(
        QueryFilter $filter,
    ): string {
        return $filter->field().$this->loopKey;
    }
}
