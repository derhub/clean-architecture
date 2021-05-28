<?php

namespace Derhub\Shared\Database\Doctrine;


use Derhub\Shared\Database\Exceptions\AggregateNotFound;
use Derhub\Shared\Database\Exceptions\FailedToSaveAggregate;
use Derhub\Shared\Model\AggregateRepository;
use Derhub\Shared\Model\AggregateRoot;
use Derhub\Shared\Model\AggregateRootId;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ObjectRepository;

/**
 * @template T
 */
abstract class DoctrinePersistenceRepository implements AggregateRepository
{
    /**
     * @var \Doctrine\ORM\EntityRepository<T>
     */
    protected EntityRepository $doctrineRepo;

    /**
     * DoctrinePersistenceRepository constructor.
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    public function __construct(
        protected EntityManagerInterface $entityManager
    ) {
        $this->doctrineRepo = $this->getDoctrineRepo();
    }

    /**
     * @var \Doctrine\ORM\EntityRepository<T>
     */
    abstract protected function getDoctrineRepo(): EntityRepository;

    abstract public function getNextId(): mixed;

    /**
     * @psalm-return T
     *
     * @param \Derhub\Shared\Model\AggregateRootId $id
     * @return object
     * @throws \Derhub\Shared\Database\Exceptions\AggregateNotFound
     */
    public function get(AggregateRootId $id): object
    {
        $find = $this->doctrineRepo->find($id);
        if ($find === null) {
            throw AggregateNotFound::fromId($id);
        }

        return $find;
    }

    public function save(AggregateRoot $aggregateRoot): void
    {
        try {
            $this->entityManager->persist($aggregateRoot);
            $this->entityManager->flush($aggregateRoot);
        } catch (OptimisticLockException | ORMException $e) {
            throw FailedToSaveAggregate::fromAggregateWithException(
                $aggregateRoot,
                $e
            );
        }
    }
}