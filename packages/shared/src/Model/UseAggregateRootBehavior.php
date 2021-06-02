<?php

namespace Derhub\Shared\Model;

trait UseAggregateRootBehavior
{
    use UseAggregateRoot {
        UseAggregateRoot::record as baseRecordEvent;
    }

    private function record(DomainEvent $event): void
    {
        $this->baseRecordEvent($event);

        $this->applyEvent($event);
    }


    public function applyEvent(DomainEvent $event): void
    {
        $handler = $this->getMethodNameFromDomainEvent($event);
        if (! method_exists($this, $handler)) {
            throw new \RuntimeException(
                sprintf(
                    'Missing event handler method %s for aggregate root %s',
                    $handler,
                    get_class($this)
                )
            );
        }

        $this->{$handler}($event);
    }

    protected function getMethodNameFromDomainEvent(DomainEvent $event): string
    {
        $class = explode('\\', get_class($event));
        $name = end($class);

        return 'when'.$name;
    }
}
