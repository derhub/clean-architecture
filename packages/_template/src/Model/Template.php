<?php

declare(strict_types=1);

namespace EB\Template\Model;

use EB\Shared\Model\AggregateRoot;
use EB\Shared\Model\DomainEvent;

use EB\Shared\Model\UseAggregateRoot;
use EB\Shared\Model\UseTimestampsWithSoftDelete;
use EB\Template\Model\ValueObject\TemplateId;

/**
 * @template-implements AggregateRoot<TemplateId>
 */
final class Template implements AggregateRoot
{
    use UseTimestampsWithSoftDelete;
    use UseAggregateRoot {
        UseAggregateRoot::record as private recordDomainEvent;
    }

    public function __construct(private TemplateId $aggregateRootId)
    {
    }

    public function aggregateRootId(): TemplateId
    {
        return $this->aggregateRootId;
    }

    private function record(DomainEvent $e): void
    {
        $this->recordDomainEvent($e);
    }

}
