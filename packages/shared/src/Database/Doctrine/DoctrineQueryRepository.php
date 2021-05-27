<?php

namespace Derhub\Shared\Database\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query;
use Doctrine\Database\ObjectRepository;
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
     * @var \Doctrine\Database\ObjectRepository<T>
     */
    protected ObjectRepository $doctrineRepo;

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
        protected EntityManagerInterface $entityManager
    ) {
        $this->doctrineRepo = $this->getRepository();
        $this->filters = [];
        $this->paginationFilter = null;
    }

    /**
     * @return \Doctrine\Database\ObjectRepository
     */
    abstract protected function getRepository(): ObjectRepository;

    abstract protected function getTableName(): string;

    public function addFilters(QueryFilter ...$filters): self
    {
        foreach ($filters as $filter) {
            if ($filter instanceof PaginationFilter) {
                $this->paginationFilter = $filter;
            } else {
                $this->filters[] = $filter;
            }
        }

        return $this;
    }

    protected function createQueryBuilderFilterFactory(
    ): DoctrineQueryBuilderFilterFactory
    {
        return new DoctrineQueryBuilderFilterFactory($this->doctrineRepo);
    }

    public function applyFilters(): \Doctrine\ORM\QueryBuilder
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
        $queryBuilder = $this->applyFilters();
        return $queryBuilder->getQuery()->getResult(Query::HYDRATE_ARRAY);
    }

    public function iterableResult(): iterable
    {
        foreach ($this->results() as $result) {
            yield $result;
        }
    }

    /**
     * @throws \Derhub\Shared\Query\NotSingleResultException
     */
    public function singleResult(): ?array
    {
        try {
            $queryBuilder = $this->applyFilters();
            return $queryBuilder
                ->getQuery()
                ->getOneOrNullResult(Query::HYDRATE_ARRAY)
                ;
        } catch (NonUniqueResultException $e) {
            throw NotSingleResultException::fromThrowable($e);
        }
    }

    public function findBy(string $field, mixed $value): array
    {
        return $this
            ->addFilters(new OperationFilter($field, 'equal', $value))
            ->results()
            ;
    }

    /**
     * @throws \Derhub\Shared\Query\NotSingleResultException
     */
    public function findOne(string $field, mixed $value): ?array
    {
        try {
            return $this
                ->addFilters(new OperationFilter($field, 'equal', $value))
                ->singleResult()
                ;
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
        } catch (\Doctrine\DBAL\Exception | \Doctrine\DBAL\Driver\Exception $e) {
            throw FailedQueryException::fromThrowable($e);
        }

        return $result === '0';
    }

}