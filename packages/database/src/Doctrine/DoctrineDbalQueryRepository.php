<?php

namespace Derhub\Shared\Database\Doctrine;

use Derhub\Shared\Database\Doctrine\Capabilities\DbalExistCapability;
use Derhub\Shared\Database\Doctrine\FilterFactories\DbalQueryBuilderFilterFactory;
use Derhub\Shared\Query\Filters\OperationFilter;
use Derhub\Shared\Query\NotSingleResultException;
use Derhub\Shared\Query\QueryFilterFactory;
use Derhub\Shared\Query\QueryItem;
use Derhub\Shared\Query\QueryItemMapperRepositoryCapabilities;
use Derhub\Shared\Query\QueryRepository;
use Derhub\Shared\Query\QueryRepositoryFilterCapabilities;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;

abstract class DoctrineDbalQueryRepository implements QueryRepository
{
    use QueryItemMapperRepositoryCapabilities;
    use QueryRepositoryFilterCapabilities;
    use DbalExistCapability;

    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    abstract protected function getTableName(): string;

    public function getConnection(): Connection
    {
        return $this->entityManager->getConnection();
    }

    public function applyFilterAndReturnQueryBuilder(): QueryBuilder
    {
        /** @var \Derhub\Shared\Database\Doctrine\FilterFactories\DbalQueryBuilderFilterFactory $filter */
        $filter = $this->applyFilters();

        return $filter->getQueryBuilder();
    }

    public function getFilterFactory(): QueryFilterFactory
    {
        $connection = $this->getConnection();
        $tableName = $this->getTableName();
        return new DbalQueryBuilderFilterFactory(
            $connection->createQueryBuilder()->select('*')->from($tableName)
        );
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     * @throws \Doctrine\DBAL\Driver\Exception
     */
    public function findBy(string $field, mixed $value): array
    {
        return $this
            ->addFilter(OperationFilter::eq($field, $value))
            ->results()
            ;
    }

    /**
     * @throws \Derhub\Shared\Query\NotSingleResultException
     * @throws \Doctrine\DBAL\Exception
     * @throws \Doctrine\DBAL\Driver\Exception
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

    /**
     * @return \Generator<QueryItem|array|null>
     * @throws \Doctrine\DBAL\Exception
     * @throws \Doctrine\DBAL\Driver\Exception
     */
    public function iterableResult(): \Generator
    {
        $raw = $this->applyFilterAndReturnQueryBuilder()
            ->execute()
            ->fetchAllAssociative()
        ;
        foreach ($raw as $result) {
            yield $this->mapResult($result);
        }
    }

    /**
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws \Doctrine\DBAL\Exception
     */
    public function results(): array
    {
        return iterator_to_array($this->iterableResult());
    }

    /**
     * @throws \Derhub\Shared\Query\NotSingleResultException
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws \Doctrine\DBAL\Exception
     */
    public function singleResult(): QueryItem|array|null
    {
        try {
            $queryBuilder = $this->applyFilterAndReturnQueryBuilder();
            $find = $queryBuilder
                ->execute()
                ->fetchAssociative()
            ;

            if (! $find) {
                return null;
            }

            return $this->mapResult($find);
        } catch (NonUniqueResultException $e) {
            throw NotSingleResultException::fromThrowable($e);
        }
    }
}
