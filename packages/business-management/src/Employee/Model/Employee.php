<?php

namespace Derhub\BusinessManagement\Employee\Model;


use Derhub\BusinessManagement\Business\Model\Exception\ChangesToDisabledBusinessException;
use Derhub\BusinessManagement\Employee\Model\Events\EmployeeInformationUpdated;
use Derhub\BusinessManagement\Employee\Model\Events\EmployeeRegistered;
use Derhub\BusinessManagement\Employee\Model\Events\EmployeeStatusChanged;
use Derhub\BusinessManagement\Employee\Model\Exceptions\EmployeeAlreadyExist;
use Derhub\BusinessManagement\Employee\Model\Specifications\UniqueEmployee;
use Derhub\BusinessManagement\Employee\Model\Specifications\UniqueEmployeeSpecification;
use Derhub\BusinessManagement\Employee\Model\Values\EmployeeId;
use Derhub\BusinessManagement\Employee\Model\Values\EmployerId;
use Derhub\BusinessManagement\Employee\Model\Values\Status;
use Derhub\Shared\Model\AggregateRoot;
use Derhub\Shared\Model\DomainEvent;
use Derhub\Shared\Model\UseAggregateRoot;
use Derhub\Shared\Model\UseTimestampsWithSoftDelete;

class Employee implements AggregateRoot
{
    use UseAggregateRoot {
        UseAggregateRoot::record as private recordDomainEvent;
    }

    use UseTimestampsWithSoftDelete;

    private EmployeeId $aggregateRootId;
    private EmployerId $employerId;
    private Details $details;
    private Status $status;

    public function __construct(?EmployeeId $aggregateRootId = null)
    {
        $this->aggregateRootId = $aggregateRootId ?? new EmployeeId();
        $this->details = new Details();
        $this->status = new Status();
        $this->employerId = new EmployerId();

        $this->initTimestamps();
    }

    public function record(DomainEvent $event): void
    {
        $this->disallowChangesWhenEmployeeIsDeleted($event);

        $this->recordDomainEvent($event);
    }


    private function disallowChangesWhenEmployeeIsDeleted(DomainEvent $event
    ): void {
        if (! $this->deletedAt->isEmpty()) {
            throw ChangesToDisabledBusinessException::notAllowed();
        }
    }

    public function aggregateRootId(): EmployeeId
    {
        return $this->aggregateRootId;
    }

    /**
     * @throws \Derhub\BusinessManagement\Employee\Model\Exceptions\EmployeeAlreadyExist
     */
    public static function registerEmployee(
        UniqueEmployeeSpecification $spec,
        EmployeeId $aggregateRootId,
        EmployerId $employer,
        Details $details,
        Status $status,
    ): self {
        $employee = new UniqueEmployee(
            employeeId: $aggregateRootId,
            employerId: $employer,
            name: $details->name(),
            initial: $details->initial(),
            position: $details->position(),
            email: $details->email(),
            birthday: $details->birthday()
        );

        if (! $spec->isSatisfiedBy($employee)) {
            throw EmployeeAlreadyExist::withName($details->name());
        }

        $self = new self($aggregateRootId);
        $self->details = $details;
        $self->status = $status;
        $self->employerId = $employer;

        $self->record(
            new EmployeeRegistered(
                employeeId: $self->aggregateRootId->toString(),
                employerId: $self->employerId->toString(),
                status: $self->status->toString(),
                name: $self->details->name(),
                initial: $self->details->initial()->toString(),
                position: $self->details->position()->toString(),
                email: $self->details->email()->toString(),
                birthday: $self->details->birthday()->toString()
            ),
        );

        return $self;
    }

    public function changeStatus(Status $status): self
    {
        if ($this->status->sameAs($status)) {
            return $this;
        }

        $this->status = $status;
        $this->record(
            new EmployeeStatusChanged(
                $this->aggregateRootId->toString(),
                $this->status->toString(),
            )
        );
        return $this;
    }

    public function updateDetails(
        UniqueEmployeeSpecification $spec,
        Details $details,
    ): self {
        if ($this->details->sameAs($details)) {
            return $this;
        }

        $employee = new UniqueEmployee(
            employeeId: $this->aggregateRootId,
            employerId: $this->employerId,
            name: $details->name(),
            initial: $details->initial(),
            position: $details->position(),
            email: $details->email(),
            birthday: $details->birthday()
        );

        if (! $spec->isSatisfiedBy($employee)) {
            throw EmployeeAlreadyExist::withName($details->name());
        }

        $this->details = $details;

        $this->record(
            new EmployeeInformationUpdated(
                $this->aggregateRootId->toString(),
                $this->details->name(),
                $this->details->position()->id(),
                $this->details->email()->toString(),
                $this->details->birthday()->toString(),
            )
        );
        return $this;
    }
}