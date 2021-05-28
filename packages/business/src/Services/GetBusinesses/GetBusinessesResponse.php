<?php

namespace Derhub\Business\Services\GetBusinesses;

use Derhub\Business\Module;
use Derhub\Business\Services\BusinessQueryItemMapper;
use Derhub\Shared\Message\Query\AbstractQueryResponse;

class GetBusinessesResponse extends AbstractQueryResponse
{
    private iterable $results;

    public function __construct() {
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
        return $this->results;
    }
}
