<?php

namespace EB\Template\Services;

use EB\Shared\Message\Query\AbstractQueryResponse;
use EB\Template\Module;

class CommonQueryResponse extends AbstractQueryResponse
{

    private iterable $results;

    public function __construct(
        private TemplateItemMapper $mapper,
    ) {
        parent::__construct();
        $this->results = [];
    }

    public function aggregate(): string
    {
        return Module::ID;
    }

    public function setResults(iterable $results): self
    {
        $this->results = $results;
        return $this;
    }

    public function result(): iterable
    {
        foreach ($this->results as $result) {
            yield $this->mapper->fromArray($result);
        }
    }
}