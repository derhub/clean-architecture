<?php

namespace Derhub\Business\Infrastructure\Database;

use Derhub\Business\Model\Business;
use Derhub\Business\Model\BusinessRepository;
use Derhub\Business\Model\Values\BusinessId;
use Derhub\Shared\Database\Memory\InMemoryPersistenceRepository;
use Derhub\Shared\Model\AggregateRoot;
use Derhub\Shared\Model\AggregateRootId;

/**
 * @extends InMemoryRepository<AggregateId>
 */
class InMemoryBusinessRepository extends InMemoryPersistenceRepository implements
    BusinessRepository
{

    public function getNextId(): BusinessId
    {
        return $this->createId();
    }

    public function get(AggregateRootId $id): ?Business
    {
        return $this->findById($id);
    }

    public function save(AggregateRoot $aggregateRoot): void
    {
        $this->persist($aggregateRoot);
    }
}
