<?php

declare(strict_types=1);

namespace EB\Template\Model;

use EB\Template\Model\ValueObject\TemplateId;
use EB\Shared\Model\AggregateRepository;

/**
 * @template-extends AggregateRepository<TemplateId, Template>
 */
interface TemplateRepository extends AggregateRepository
{
    public function getNextId(): TemplateId;

    public function save(Template $aggregateRoot): void;

    public function get(TemplateId $aggregateAggregateId): ?Template;
}
