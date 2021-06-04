<?php

namespace Derhub\BusinessManagement\Employee\Services\NewEmployee;

use Derhub\BusinessManagement\Employee\Infrastructure\Database\EmployeePersistenceRepository;
use Derhub\BusinessManagement\Employee\Model\Details;
use Derhub\BusinessManagement\Employee\Model\Employee;
use Derhub\BusinessManagement\Employee\Model\Specifications\UniqueEmployeeSpecification;
use Derhub\BusinessManagement\Employee\Model\Values\Email;
use Derhub\BusinessManagement\Employee\Model\Values\EmployeePosition;
use Derhub\BusinessManagement\Employee\Model\Values\EmployerId;
use Derhub\BusinessManagement\Employee\Model\Values\Initial;
use Derhub\BusinessManagement\Employee\Model\Values\Status;
use Derhub\BusinessManagement\Employee\Services\EmployeeCommandResponse;
use Derhub\Shared\Values\DateTimeLiteral;

class NewEmployeeHandler
{
    public function __construct(
        private EmployeePersistenceRepository $repo,
        private UniqueEmployeeSpecification $uniqueEmployeeSpec,
    ) {
    }

    /**
     * @throws \Derhub\BusinessManagement\Employee\Model\Exceptions\EmployeeAlreadyExist
     */
    public function __invoke(NewEmployee $cmd): EmployeeCommandResponse
    {
        $id = $this->repo->getNextId();

        $details = Details::with(
            name: $cmd->name(),
            initial: Initial::fromString($cmd->initial()),
            position: EmployeePosition::fromString($cmd->position()),
            email: Email::fromString($cmd->email()),
            birthday: DateTimeLiteral::fromString($cmd->birthday())
        );

        $model = Employee::newEmployee(
            spec: $this->uniqueEmployeeSpec,
            aggregateRootId: $id,
            employer: EmployerId::fromString($cmd->employerId()),
            details: $details,
            status: Status::fromString($cmd->statusId())
        );

        $this->repo->save($model);

        return new EmployeeCommandResponse($id);
    }
}