<?php

namespace Derhub\Shared\Database\Doctrine;

use Derhub\Shared\Query\FailedQueryException;
use Derhub\Shared\Query\QueryFilterFactory;
use Derhub\Shared\Query\QueryItem;
use Derhub\Shared\Query\QueryItemMapper;
use Derhub\Shared\Query\QueryItemMapperRepositoryCapabilities;
use Derhub\Shared\Query\QueryRepositoryFilterCapabilities;
use Doctrine\DBAL\Driver\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query;
use Derhub\Shared\Query\Filters\OperationFilter;
use Derhub\Shared\Query\NotSingleResultException;
use Derhub\Shared\Query\QueryRepository;
use Doctrine\ORM\QueryBuilder;
use Generator;

/**
 * @template T
 */
abstract class DoctrineQueryRepository implements QueryRepository
{
    use QueryItemMapperRepositoryCapabilities;
    use QueryRepositoryFilterCapabilities;

    /**
     * @return \Doctrine\ORM\EntityRepository<T>
     */
    protected EntityRepository $doctrineRepo;

    /**
     * DoctrineQueryBusinessRepository constructor.
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    public function __construct(
        protected EntityManagerInterface $entityManager,
        ?QueryItemMapper $mapper = null,
    ) {
        $this->doctrineRepo = $this->getRepository();

        if ($mapper !== null) {
            $this->setMapper($mapper);
        }
    }

    public function applyFilterAndReturnQueryBuilder(): QueryBuilder
    {
        /** @var DoctrineQueryBuilderFilterFactory $filter */
        $filter = $this->applyFilters();

        return $filter->getQueryBuilder();
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

    public function findBy(string $field, mixed $value): array
    {
        return $this
            ->addFilter(OperationFilter::eq($field, $value))
            ->results()
            ;
    }

    /**
     * @throws \Derhub\Shared\Query\NotSingleResultException
     */
    public function findOne(string $field, mixed $value): QueryItem|array|null
    {
        try {
            $find = $this
                ->addFilter(OperationFilter::eq($field, $value))
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

    public function getFilterFactory(): QueryFilterFactory
    {
        return new DoctrineQueryBuilderFilterFactory($this->getRepository());
    }

    /**
     * @return \Generator<QueryItem|array|null>
     */
    public function iterableResult(): Generator
    {
        $raw = $this->applyFilterAndReturnQueryBuilder()
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY)
        ;
        foreach ($raw as $result) {
            yield $this->mapResult($result);
        }
    }

    public function results(): array
    {
        return iterator_to_array($this->iterableResult());
    }

    /**
     * @throws \Derhub\Shared\Query\NotSingleResultException
     */
    public function singleResult(): QueryItem|array|null
    {
        try {
            $queryBuilder = $this->applyFilterAndReturnQueryBuilder();
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

    /**
     * @return \Doctrine\ORM\EntityRepository<T>
     */
    abstract protected function getRepository(): EntityRepository;

    abstract protected function getTableName(): string;
}
