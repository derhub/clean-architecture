<?php

namespace Tests\Integration\Fixtures\Query;

use Derhub\Shared\Message\Query\AbstractQueryResponse;
use Derhub\Shared\Message\Query\QueryResponse;

class QueryResponseFixture extends AbstractQueryResponse implements QueryResponse
{
    public function __construct(private mixed $msg)
    {
        parent::__construct();
    }

    public function aggregate(): string
    {
        return 'test';
    }

    public function result(): iterable
    {
        yield 'test';
    }

    public function getMessage(): mixed
    {
        return $this->msg;
    }

    public function errors(): array
    {
        return [];
    }
}