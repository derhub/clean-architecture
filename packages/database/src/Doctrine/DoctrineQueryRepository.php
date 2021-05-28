<?php

namespace Derhub\Shared\Database\Doctrine;

use Derhub\Shared\Query\FailedQueryException;
use Derhub\Shared\Query\QueryItemMapper;
use Doctrine\DBAL\Driver\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Derhub\Shared\Query\Filters\OperationFilter;
use Derhub\Shared\Query\Filters\PaginationFilter;
use Derhub\Shared\Query\NotSingleResultException;
use Derhub\Shared\Query\QueryFilter;
use Derhub\Shared\Query\QueryRepository;

/**
 * @template T
 */
abstract class DoctrineQueryRepository implements QueryRepository
{
    /**
     * @return \Doctrine\ORM\EntityRepository<T>
     */
    protected EntityRepository $doctrineRepo;

    /**
     * @var QueryFilter[]
     */
    protected array $filters;

    protected ?PaginationFilter $paginationFilter;

    /**
     * DoctrineQueryBusinessRepository constructor.
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected QueryItemMapper $mapper,
    ) {
        $this->doctrineRepo = $this->getRepository();
        $this->filters = [];
        $this->paginationFilter = null;
    }

    /**
     * @return \Doctrine\ORM\EntityRepository<T>
     */
    abstract protected function getRepository(): EntityRepository;

    abstract protected function getTableName(): string;

    protected function mapResult(array $data): mixed
    {
        return $this->mapper->fromArray($data);
    }

    public function addFilters(array $filters): self
    {
        foreach ($filters as $filter) {
            $this->addFilter($filter);
        }

        return $this;
    }

    public function addFilter(QueryFilter $filter): self
    {
        if ($filter instanceof PaginationFilter) {
            $this->paginationFilter = $filter;
        } else {
            $this->filters[] = $filter;
        }

        return $this;
    }

    protected function createQueryBuilderFilterFactory(
    ): DoctrineQueryBuilderFilterFactory
    {
        return new DoctrineQueryBuilderFilterFactory($this->doctrineRepo);
    }

    public function applyFilters(): QueryBuilder
    {
        $filterFactory = $this->createQueryBuilderFilterFactory();

        if ($this->paginationFilter !== null) {
            $filterFactory->create($this->paginationFilter);
        }

        foreach ($this->filters as $key => $filter) {
            $filterFactory->createWithLoopKey($key, $filter);
        }

        return $filterFactory->getQueryBuilder();
    }

    public function results(): array
    {
        return iterator_to_array($this->iterableResult());
    }

    public function iterableResult(): \Generator
    {
        $queryBuilder = $this->applyFilters();
        $raw = $queryBuilder->getQuery()->getResult(Query::HYDRATE_ARRAY);
        foreach ($raw as $result) {
            yield $this->mapResult($result);
        }
    }

    /**
     * @throws \Derhub\Shared\Query\NotSingleResultException
     */
    public function singleResult(): mixed
    {
        try {
            $queryBuilder = $this->applyFilters();
            $find = $queryBuilder
                ->getQuery()
                ->getOneOrNullResult(Query::HYDRATE_ARRAY)
            ;

            if ($find === null) {
                return null;
            }

            return $this->mapResult($find);
        } catch (NonUniqueResultException $e) {
            throw NotSingleResultException::fromThrowable($e);
        }
    }

    public function findBy(string $field, mixed $value): array
    {
        return $this
            ->addFilter(new OperationFilter($field, 'equal', $value))
            ->results()
            ;
    }

    /**
     * @throws \Derhub\Shared\Query\NotSingleResultException
     */
    public function findOne(string $field, mixed $value): mixed
    {
        try {
            $find = $this
                ->addFilter(new OperationFilter($field, 'equal', $value))
                ->singleResult()
            ;

            if ($find === null) {
                return null;
            }

            return $this->mapResult($find);
        } catch (NotSingleResultException $e) {
            throw NotSingleResultException::fromThrowable($e);
        }
    }

    /**
     * @throws \Derhub\Shared\Query\FailedQueryException
     */
    public function exists(string $field, mixed $value): bool
    {
        $connection = $this->entityManager->getConnection();
        $expr = $connection->getExpressionBuilder();
        $query = $connection->createQueryBuilder()
            ->select(['1'])
            ->from(sprintf('`%s`', $this->getTableName()), 'b')
            ->where($expr->eq('b.'.$field, '?'))
        ;

        try {
            $result = $connection->createQueryBuilder()
                ->select('EXISTS('.$query->getSQL().')')
                ->setParameter(1, $value)
                ->execute()
                ->fetchOne()
            ;
        } catch (\Doctrine\DBAL\Exception | Exception $e) {
            throw FailedQueryException::fromThrowable($e);
        }

        return $result === '0';
    }

}