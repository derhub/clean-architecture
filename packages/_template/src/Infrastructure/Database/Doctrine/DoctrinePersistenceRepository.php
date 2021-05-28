<?php

namespace EB\Template\Infrastructure\Database\Doctrine;

use EB\Template\Model\Template;
use EB\Template\Model\TemplateRepository;
use EB\Template\Model\ValueObject\TemplateId;

class DoctrinePersistenceRepository implements TemplateRepository
{

    public function getNextId(): TemplateId
    {
    }

    public function save(Template $aggregateRoot): void
    {
    }

    public function get(TemplateId $aggregateAggregateId): ?Template
    {
    }
}