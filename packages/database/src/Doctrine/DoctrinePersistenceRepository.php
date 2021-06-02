<?php

namespace Derhub\Shared\Database\Doctrine;

use Derhub\Shared\Database\Exceptions\AggregateNotFound;
use Derhub\Shared\Database\Exceptions\FailedToSaveAggregate;
use Derhub\Shared\Persistence\DatabasePersistenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

/**
 * @template T
 */
class DoctrinePersistenceRepository implements DatabasePersistenceRepository
{
    /**
     * @var \Doctrine\ORM\EntityRepository<T>|null
     */
    protected ?EntityRepository $doctrineRepo;
    private ?string $aggregateClassName;

    /**
     * DoctrinePersistenceRepository constructor.
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    public function __construct(
        protected EntityManagerInterface $entityManager
    ) {
        $this->aggregateClassName = null;
        $this->doctrineRepo = null;
    }

    /**
     * @param class-string<T> $className
     * @throws \Exception
     */
    public function setAggregateClass(string $className): void
    {
        $this->aggregateClassName = $className;
        $this->doctrineRepo = $this->entityManager->getRepository($className);
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     * @throws \Derhub\Shared\Database\Doctrine\MissingAggregateClassNameException
     */
    protected function getDoctrineRepo(): EntityRepository
    {
        if ($this->aggregateClassName === null) {
            throw MissingAggregateClassNameException::notProvided();
        }

        return $this->doctrineRepo;
    }

    /**
     * @param string|int $aggregateRootId
     * @return object
     * @throws \Derhub\Shared\Database\Exceptions\AggregateNotFound
     * @throws \Derhub\Shared\Database\Doctrine\MissingAggregateClassNameException
     */
    public function findById(string|int $aggregateRootId): object
    {
        $find = $this->getDoctrineRepo()->find($aggregateRootId);
        if ($find === null) {
            throw AggregateNotFound::fromId($aggregateRootId);
        }

        return $find;
    }

    /**
     * @throws \Derhub\Shared\Database\Exceptions\FailedToSaveAggregate
     */
    public function persist(object $aggregateRoot): void
    {
        try {
            $this->entityManager->persist($aggregateRoot);
            $this->entityManager->flush($aggregateRoot);
        } catch (OptimisticLockException | ORMException $e) {
            throw FailedToSaveAggregate::fromObjectWithException(
                $aggregateRoot,
                $e
            );
        }
    }
}
