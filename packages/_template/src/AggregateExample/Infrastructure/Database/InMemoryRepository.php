<?php

namespace Derhub\Template\AggregateExample\Infrastructure\Database;

use Derhub\Shared\Database\Memory\InMemoryPersistenceRepository;
use Derhub\Shared\Model\AggregateRoot;
use Derhub\Shared\Model\AggregateRootId;
use Derhub\Template\AggregateExample\Model\Template;
use Derhub\Template\AggregateExample\Model\TemplateRepository;
use Derhub\Template\AggregateExample\Model\Values\TemplateId;

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
