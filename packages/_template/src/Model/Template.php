<?php

declare(strict_types=1);

namespace Derhub\Template\Model;

use Derhub\Shared\Values\DateTimeLiteral;
use Derhub\Template\Model\Event\TemplateNameChanged;
use Derhub\Template\Model\Event\TemplatePublished;
use Derhub\Template\Model\Event\TemplateRestored;

use Derhub\Template\Model\Exception\ChangesNotAllowed;

use Derhub\Template\Model\Exception\InvalidName;
use Derhub\Template\Model\Specification\UniqueName;
use Derhub\Template\Model\Specification\UniqueNameSpec;
use Derhub\Shared\Model\AggregateRoot;
use Derhub\Shared\Model\DomainEvent;
use Derhub\Shared\Model\UseAggregateRoot;

use Derhub\Template\Model\Values\Name;
use Derhub\Template\Model\Values\TemplateId;
use Derhub\Shared\Model\UseTimestampsWithSoftDelete;

/**
 * @template-implements AggregateRoot<BusinessId>
 */
final class Template implements AggregateRoot
{
    use UseTimestampsWithSoftDelete;
    use UseAggregateRoot {
        UseAggregateRoot::record as private _record;
    }

    private TemplateId $aggregateRootId;
    private Name $name;
    private bool $publish;

    public function __construct(?TemplateId $aggregateRootId = null)
    {
        $this->aggregateRootId = $aggregateRootId ?? new TemplateId();
        $this->name = new Name();
        $this->initTimestamps();
    }

    public function aggregateRootId(): TemplateId
    {
        return $this->aggregateRootId;
    }

    public function restore(): self
    {
        $this->deletedAt = DateTimeLiteral::createEmpty();
        $this->record(
            new TemplateRestored($this->aggregateRootId->toString())
        );
        return $this;
    }

    public function changeName(UniqueNameSpec $nameSpec, Name $name): self
    {
        if (! $nameSpec->isSatisfiedBy(new UniqueName($name))) {
            throw InvalidName::notUnique($name);
        }

        $this->name = $name;

        $this->record(
            new TemplateNameChanged(
                $this->aggregateRootId->toString(),
                $this->name->toString()
            )
        );
        return $this;
    }

    /**
     * @throws \Derhub\Template\Model\Exception\ChangesNotAllowed
     */
    protected function record(DomainEvent $e): void
    {
        $this->disallowChangesWhenDisabled($e);

        $this->_record($e);
    }

    /**
     * @throws \Derhub\Template\Model\Exception\ChangesNotAllowed
     */
    private function disallowChangesWhenDisabled(DomainEvent $e): void
    {
        if ($e instanceof TemplateRestored) {
            return;
        }

        if (! $this->deletedAt->isEmpty()) {
            throw ChangesNotAllowed::whenDeleted();
        }
    }

    public function publish(): self
    {
        $this->publish = true;
        $this->record(
            new TemplatePublished($this->aggregateRootId->toString()),
        );
        return $this;
    }
}
