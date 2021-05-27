<?php

namespace Derhub\Business\Infrastructure\Database;

use Derhub\Business\Model\Business;
use Derhub\Business\Model\BusinessRepository;
use Derhub\Business\Model\Values\BusinessId;
use Derhub\Shared\Infrastructure\Memory\InMemoryRepository;

/**
 * @extends InMemoryRepository<AggregateId>
 */
class InMemoryBusinessRepository extends InMemoryRepository implements
    BusinessRepository
{

    public function getNextId(): BusinessId
    {
        return $this->createId();
    }

    public function get(BusinessId $id): ?Business
    {
        return $this->findById($id);
    }

    public function save(Business $entity): void
    {
        $this->persist($entity);
    }
}
