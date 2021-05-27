<?php
/**
 * Created By: Johnder Baul<imjohnderbaul@gmail.com>
 * Date: 3/28/21
 */

namespace Derhub\Shared\Model;

use Derhub\Shared\Values\DateTimeLiteral;

trait UseAggregateRoot
{
    private bool $isInCreateState = false;
    /**
     * Holds the domain events
     * @var DomainEvent[]
     */
    protected array $events = [];

    /**
     * @return DomainEvent[]
     */
    public function pullEvents(): array
    {
        $events = $this->events;
        $this->events = [];

        return $events;
    }

    protected function record(DomainEvent $event): void
    {
        $this->events[] = $event;
        $this->applyTimestamps();
    }


    protected function applyTimestamps(): void
    {
        if (! isset($this->updatedAt, $this->createdAt)) {
            return;
        }

        if ($this->createdAt->isEmpty()) {
            $this->createdAt = DateTimeLiteral::now();
        } else {
            $this->updatedAt = DateTimeLiteral::now();
        }
    }
}
