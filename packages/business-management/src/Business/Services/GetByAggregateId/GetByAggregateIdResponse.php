<?php

namespace Derhub\BusinessManagement\Business\Services\GetByAggregateId;

use Derhub\BusinessManagement\Business\Module;
use Derhub\Shared\Message\Query\AbstractQueryResponse;

class GetByAggregateIdResponse extends AbstractQueryResponse
{
    private iterable $result;

    public function __construct()
    {
        parent::__construct();

        $this->result = [];
    }

    public function setResult(iterable $result): void
    {
        $this->result = $result;
    }

    public function aggregate(): string
    {
        return Module::ID;
    }

    public function result(): iterable
    {
        return $this->result;
    }
}