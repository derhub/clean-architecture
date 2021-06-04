<?php

namespace Derhub\BusinessManagement\Employee\Services;

use Derhub\Shared\Query\QueryItem;

class EmployeeQueryItem implements QueryItem
{
    public function __construct(
        private string $aggregateRootId,
        private string $employerId,
        private string $status,
        private string $name,
        private string $initial,
        private string $position,
        private string $email,
        private string $birthday,
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->aggregateRootId(),
            'employer_id' => $this->employerId(),
            'status' => $this->status(),
            'name' => $this->name(),
            'email' => $this->email(),
            'initial' => $this->initial(),
            'position' => $this->position(),
            'birthday' => $this->birthday(),
        ];
    }

    public function aggregateRootId(): string
    {
        return $this->aggregateRootId;
    }

    public function employerId(): string
    {
        return $this->employerId;
    }

    public function status(): string
    {
        return $this->status;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function initial(): string
    {
        return $this->initial;
    }

    public function position(): string
    {
        return $this->position;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function birthday(): string
    {
        return $this->birthday;
    }
}