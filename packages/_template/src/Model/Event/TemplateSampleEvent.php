<?php

declare(strict_types=1);

namespace EB\Template\Model\Event;

use EB\Shared\Model\DomainEvent;
use EB\Template\Model\ValueObject\TemplateId;
use EB\Shared\Model\AggregateRootId;

/**
 * Class TemplateSampleEvent
 * @package EB\Template\Model\Event
 *
 * @implements DomainEvent<TemplateId>
 */
final class TemplateSampleEvent implements DomainEvent
{
    private int $version = 1;

    public function __construct(private string $aggregateRootId)
    {
    }

    public function aggregateRootId(): string
    {
        return $this->aggregateRootId;
    }

    public function version(): int
    {
        return $this->version;
    }
}
