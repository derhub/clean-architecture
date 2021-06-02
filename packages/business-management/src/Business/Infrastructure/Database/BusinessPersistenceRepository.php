<?php

namespace Derhub\BusinessManagement\Business\Infrastructure\Database;

use Derhub\BusinessManagement\Business\Model\Business;
use Derhub\BusinessManagement\Business\Model\BusinessRepository;
use Derhub\BusinessManagement\Business\Model\Values\BusinessId;
use Derhub\Shared\Model\AggregateRoot;
use Derhub\Shared\Model\AggregateRootId;
use Derhub\Shared\Persistence\DatabasePersistenceRepository;

class BusinessPersistenceRepository implements BusinessRepository
{
    public function __construct(
        private DatabasePersistenceRepository $persistence
    ) {
        $this->persistence->setAggregateClass(Business::class);
    }

    public function getNextId(): BusinessId
    {
        return BusinessId::generate();
    }

    public function get(AggregateRootId $id): Business
    {
        return $this->persistence->findById($id->toString());
    }

    public function save(AggregateRoot $aggregateRoot): void
    {
        $this->persistence->persist($aggregateRoot);
    }
}