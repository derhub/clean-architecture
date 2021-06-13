<?php

namespace Derhub\Template\AggregateExample\Infrastructure\Database;

use Derhub\Shared\Model\AggregateRepository;
use Derhub\Shared\Model\AggregateRoot;
use Derhub\Shared\Model\AggregateRootId;
use Derhub\Shared\Persistence\PersistenceRepository;
use Derhub\Template\AggregateExample\Model\Values\SampleId;

class DBPersistenceRepository implements AggregateRepository
{
    public function __construct(
        private PersistenceRepository $repo
    ) {
    }

    /**
     * @param \Derhub\Template\AggregateExample\Model\Values\SampleId $id
     * @return mixed
     */
    public function get(AggregateRootId $id): mixed
    {
        return $this->repo->findById($id->toBytes());
    }

    public function getNextId(): SampleId
    {
        return SampleId::generate();
    }

    public function save(AggregateRoot $aggregateRoot): void
    {
        $this->repo->persist($aggregateRoot);
    }
}