<?php

declare(strict_types=1);

namespace Derhub\Template\AggregateExample\Model;

use Derhub\Shared\Model\AggregateRoot;
use Derhub\Shared\Model\DomainEvent;
use Derhub\Shared\Model\UseAggregateRoot;
use Derhub\Shared\Model\UseTimestampsWithSoftDelete;
use Derhub\Shared\Values\DateTimeLiteral;
use Derhub\Template\AggregateExample\Model\Event\TemplateNameChanged;
use Derhub\Template\AggregateExample\Model\Event\TemplateStatusChanged;
use Derhub\Template\AggregateExample\Model\Event\TemplateRestored;
use Derhub\Template\AggregateExample\Model\Exception\ChangesNotAllowed;
use Derhub\Template\AggregateExample\Model\Exception\InvalidName;
use Derhub\Template\AggregateExample\Model\Specification\UniqueName;
use Derhub\Template\AggregateExample\Model\Specification\UniqueNameSpec;
use Derhub\Template\AggregateExample\Model\Values\Name;
use Derhub\Template\AggregateExample\Model\Values\Status;
use Derhub\Template\AggregateExample\Model\Values\TemplateId;

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
    private Status $status;

    public function __construct(?TemplateId $aggregateRootId = null)
    {
        $this->aggregateRootId = $aggregateRootId ?? new TemplateId();
        $this->name = new Name();
        $this->status = Status::draft();
        $this->initTimestamps();
    }

    public function aggregateRootId(): TemplateId
    {
        return $this->aggregateRootId;
    }

    /**
     * @throws \Derhub\Template\AggregateExample\Model\Exception\ChangesNotAllowed
     */
    public function restore(): self
    {
        $this->deletedAt = DateTimeLiteral::createEmpty();
        $this->record(
            new TemplateRestored($this->aggregateRootId->toString())
        );
        return $this;
    }

    /**
     * @throws \Derhub\Template\AggregateExample\Model\Exception\InvalidName
     * @throws \Derhub\Template\AggregateExample\Model\Exception\ChangesNotAllowed
     */
    public function changeName(UniqueNameSpec $nameSpec, Name $name): self
    {
        if (! $nameSpec->isSatisfiedBy(new UniqueName($name))) {
            throw InvalidName::notUnique($name);
        }

        $this->name = $name;
        $this->record(
            new TemplateNameChanged(
                $this->aggregateRootId->toString(),
                $this->name->toString(),
            )
        );
        return $this;
    }

    /**
     * @throws \Derhub\Template\AggregateExample\Model\Exception\ChangesNotAllowed
     */
    protected function record(DomainEvent $e): void
    {
        $this->disallowChangesWhenDisabled($e);

        $this->_record($e);
    }

    /**
     * @throws \Derhub\Template\AggregateExample\Model\Exception\ChangesNotAllowed
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

    /**
     * @throws \Derhub\Template\AggregateExample\Model\Exception\ChangesNotAllowed
     */
    public function publish(): self
    {
        $this->status = Status::publish();
        $this->record(
            new TemplateStatusChanged(
                $this->aggregateRootId->toString(), $this->status->toString()
            ),
        );
        return $this;
    }

    /**
     * @throws \Derhub\Template\AggregateExample\Model\Exception\ChangesNotAllowed
     */
    public function unPublish(): self
    {
        $this->status = Status::unPublish();
        $this->record(
            new TemplateStatusChanged(
                $this->aggregateRootId->toString(), $this->status->toString()
            ),
        );
        return $this;
    }
}
