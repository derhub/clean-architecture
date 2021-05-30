<?php

namespace Derhub\Template\Infrastructure\Database;

use Derhub\Template\Model\Template;
use Derhub\Template\Model\TemplateRepository;
use Derhub\Template\Model\Values\TemplateId;
use Derhub\Shared\Database\Memory\InMemoryPersistenceRepository;
use Derhub\Shared\Model\AggregateRoot;
use Derhub\Shared\Model\AggregateRootId;

/**
 * @extends InMemoryRepository<AggregateId>
 */
class InMemoryRepository extends InMemoryPersistenceRepository implements
    TemplateRepository
{

    public function getNextId(): TemplateId
    {
        return $this->createId();
    }

    public function get(AggregateRootId $id): ?Template
    {
        return $this->findById($id);
    }

    public function save(AggregateRoot $aggregateRoot): void
    {
        $this->persist($aggregateRoot);
    }
}
