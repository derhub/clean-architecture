<?php

namespace Derhub\Shared\Database\Doctrine;

use Derhub\Shared\Database\Doctrine\Capabilities\DbalExistCapability;
use Derhub\Shared\Database\Doctrine\FilterFactories\ObjectRepositoryFilterFactory;
use Derhub\Shared\Query\QueryFilterFactory;
use Derhub\Shared\Query\QueryItem;
use Derhub\Shared\Query\QueryItemMapper;
use Derhub\Shared\Query\QueryItemMapperRepositoryCapabilities;
use Derhub\Shared\Query\QueryRepositoryFilterCapabilities;
use Doctrine\DBAL\Connection;
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
    use DbalExistCapability;

    /**
     * DoctrineQueryBusinessRepository constructor.
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    public function __construct(
        protected EntityManagerInterface $entityManager,
        ?QueryItemMapper $mapper = null,
    ) {
        if ($mapper !== null) {
            $this->setMapper($mapper);
        }
    }

    /**
     * @return \Doctrine\ORM\EntityRepository<T>
     */
    abstract protected function getRepository(): EntityRepository;

    abstract protected function getTableName(): string;

    public function getConnection(): Connection
    {
        return $this->entityManager->getConnection();
    }

    public function applyFilterAndReturnQueryBuilder(): QueryBuilder
    {
        /** @var ObjectRepositoryFilterFactory $filter */
        $filter = $this->applyFilters();

        return $filter->getQueryBuilder();
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
        return new ObjectRepositoryFilterFactory($this->getRepository());
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
}
