<?php

namespace Derhub\Shared\Message\Query;

use Derhub\Shared\Message\AbstractMessageResponse;

/**
 * @template T
 */
abstract class AbstractQueryResponse extends AbstractMessageResponse
    implements QueryResponse
{
    /**
     * @var iterable<T>
     */
    protected iterable $results;

    public function __construct(iterable $results = [])
    {
        parent::__construct();

        $this->results = $results;
    }

    public function setResults(iterable $results): self
    {
        $this->results = $results;
        return $this;
    }

    /**
     * @return iterable<T>
     */
    public function results(): iterable
    {
        return $this->results;
    }

    public function firstResult(): mixed
    {
        foreach ($this->result() as $item) {
            return $item;
        }

        return null;
    }
}