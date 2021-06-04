<?php

namespace Derhub\BusinessManagement\Employee\Services;

use Derhub\Shared\Query\QueryItem;
use Derhub\Shared\Query\QueryItemMapper;

class EmployeeQueryMapper implements QueryItemMapper
{
    public function fromArray(array $data): QueryItem
    {
        return new EmployeeQueryItem(
            aggregateRootId: $data['aggregateRootId'],
            employerId: $data['employerId'],
            status: $data['status'],
            name: $data['details.name'],
            initial: $data['details.initial'],
            position: $data['details.position'],
            email: $data['details.email'],
            birthday: $data['details.birthday'],
        );
    }
}