<?php

namespace Derhub\Template\Infrastructure\Database;

use Derhub\Template\Model\Template;
use Derhub\Template\Model\TemplateRepository;
use Derhub\Template\Model\Values\TemplateId;
use Derhub\Shared\Model\AggregateRoot;
use Derhub\Shared\Model\AggregateRootId;
use Derhub\Shared\Persistence\DatabasePersistenceRepository;

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