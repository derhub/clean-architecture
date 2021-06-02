<?php

namespace Derhub\BusinessManagement\Business\Infrastructure\Database;

use Derhub\BusinessManagement\Business\Model\Business;
use Derhub\BusinessManagement\Business\Model\BusinessRepository;
use Derhub\BusinessManagement\Business\Model\Values\BusinessId;
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
