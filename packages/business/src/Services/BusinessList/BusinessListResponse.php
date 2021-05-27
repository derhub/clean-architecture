<?php

namespace Derhub\Business\Services\BusinessList;

use Derhub\Business\Module;
use Derhub\Business\Services\BusinessQueryItemMapper;
use Derhub\Shared\Message\Query\AbstractQueryResponse;

class BusinessListResponse extends AbstractQueryResponse
{
    private iterable $results;

    public function __construct(
        private BusinessQueryItemMapper $mapper,

    ) {
        parent::__construct();

        $this->results = [];
    }

    public function setResults(iterable $results): self
    {
        $this->results = $results;
        return $this;
    }

    public function aggregate(): string
    {
        return Module::ID;
    }

    /**
     * @return iterable<\Derhub\Business\Services\BusinessQueryItem>
     */
    public function result(): iterable
    {
        foreach ($this->results as $item) {
            yield $this->mapper->fromArray($item);
        }
    }
}
