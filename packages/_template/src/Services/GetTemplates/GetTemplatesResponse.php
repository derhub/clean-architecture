<?php

namespace Derhub\Template\Services\GetTemplates;

use Derhub\Template\Module;
use Derhub\Template\Services\BusinessQueryItemMapper;
use Derhub\Shared\Message\Query\AbstractQueryResponse;

class GetTemplatesResponse extends AbstractQueryResponse
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
     * @return iterable<\Derhub\Template\Services\BusinessQueryItem>
     */
    public function result(): iterable
    {
        return $this->results;
    }
}
