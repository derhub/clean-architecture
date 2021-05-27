<?php

namespace Derhub\Business\Services\FindByAggregateId;

use Derhub\Business\Module;
use Derhub\Business\Services\BusinessQueryItem;
use Derhub\Business\Services\BusinessItemMapperImpl;
use Derhub\Business\Services\BusinessQueryItemMapper;
use Derhub\Shared\Message\Query\AbstractQueryResponse;

class FindByAggregateIdResponse extends AbstractQueryResponse
{
    private iterable $result;

    public function __construct(private BusinessQueryItemMapper $mapper)
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
        foreach ($this->result as $item) {
            yield $this->mapper->fromArray($item);
        }
    }

}