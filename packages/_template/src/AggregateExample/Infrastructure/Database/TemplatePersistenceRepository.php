<?php

namespace Derhub\Template\AggregateExample\Infrastructure\Database;

use Derhub\Shared\Model\AggregateRoot;
use Derhub\Shared\Model\AggregateRootId;
use Derhub\Shared\Persistence\DatabasePersistenceRepository;
use Derhub\Template\AggregateExample\Model\Template;
use Derhub\Template\AggregateExample\Model\TemplateRepository;
use Derhub\Template\AggregateExample\Model\Values\TemplateId;

class TemplatePersistenceRepository implements TemplateRepository
{
    public function __construct(
        private DatabasePersistenceRepository $persistence
    ) {
        $this->persistence->setAggregateClass(Template::class);
    }

    public function getNextId(): TemplateId
    {
        return TemplateId::generate();
    }

    public function get(AggregateRootId $id): Template
    {
        return $this->persistence->findById($id->toString());
    }

    public function save(AggregateRoot $aggregateRoot): void
    {
        $this->persistence->persist($aggregateRoot);
    }
}
