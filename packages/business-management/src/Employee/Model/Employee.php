<?php

namespace Derhub\BusinessManagement\Employee\Model;


use Derhub\BusinessManagement\Employee\Model\Events\EmployeeInformationUpdated;
use Derhub\BusinessManagement\Employee\Model\Events\EmployeeStatusChanged;
use Derhub\BusinessManagement\Employee\Model\Exceptions\EmployeeAlreadyExist;
use Derhub\BusinessManagement\Employee\Model\Specifications\UniqueEmployee;
use Derhub\BusinessManagement\Employee\Model\Specifications\UniqueEmployeeSpecification;
use Derhub\BusinessManagement\Employee\Model\Values\EmployeeId;
use Derhub\BusinessManagement\Employee\Model\Values\EmployerId;
use Derhub\BusinessManagement\Employee\Model\Details;
use Derhub\BusinessManagement\Employee\Model\Values\Status;
use Derhub\Shared\Model\AggregateRoot;
use Derhub\Shared\Model\UseAggregateRoot;
use Derhub\Shared\Model\UseTimestampsWithSoftDelete;

class Employee implements AggregateRoot
{
    use UseAggregateRoot;
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

    public function aggregateRootId(): EmployeeId
    {
        return $this->aggregateRootId;
    }

    /**
     * @throws \Derhub\BusinessManagement\Employee\Model\Exceptions\EmployeeAlreadyExist
     */
    public static function newEmployee(
        UniqueEmployeeSpecification $spec,
        EmployeeId $aggregateRootId,
        EmployerId $employer,
        Details $details,
        Status $status,
    ): self {
        $employee = new UniqueEmployee(
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

    public function updateInformation(Details $details): self
    {
        if ($this->details->sameAs($details)) {
            return $this;
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