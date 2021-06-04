<?php

namespace Derhub\BusinessManagement\Employee\Services\UpdateDetails;

use Derhub\BusinessManagement\Employee\Infrastructure\Database\EmployeePersistenceRepository;
use Derhub\BusinessManagement\Employee\Model\Details;
use Derhub\BusinessManagement\Employee\Model\Specifications\UniqueEmployeeSpecification;
use Derhub\BusinessManagement\Employee\Model\Values\Email;
use Derhub\BusinessManagement\Employee\Model\Values\EmployeePosition;
use Derhub\BusinessManagement\Employee\Model\Values\EmployerId;
use Derhub\BusinessManagement\Employee\Model\Values\Initial;
use Derhub\BusinessManagement\Employee\Services\EmployeeCommandResponse;
use Derhub\Shared\Values\DateTimeLiteral;

class UpdateEmployeeDetailsHandler
{
    public function __construct(
        private EmployeePersistenceRepository $repo,
        private UniqueEmployeeSpecification $uniqueEmployeeSpec,
    ) {
    }

    public function __invoke(
        UpdateEmployeeDetails $cmd
    ): EmployeeCommandResponse {
        $model = $this->repo->get(EmployerId::fromString($cmd->employeeId()));

        $details = Details::with(
            name: $cmd->name(),
            initial: Initial::fromString($cmd->initial()),
            position: EmployeePosition::fromString($cmd->position()),
            email: Email::fromString($cmd->email()),
            birthday: DateTimeLiteral::fromString($cmd->birthday())
        );

        $model->updateDetails($this->uniqueEmployeeSpec, $details);
        $this->repo->save($model);

        return new EmployeeCommandResponse($cmd->employeeId());
    }
}