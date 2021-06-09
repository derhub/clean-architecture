<?php

namespace Derhub\Shared\Query;

trait QueryRepositoryFilterCapabilities
{
    protected array $filters = [];

    abstract public function getFilterFactory(): QueryFilterFactory;

    public function addFilter(QueryFilter $filter): static
    {
        $this->filters[] = $filter;

        return $this;
    }

    /**
     * @param QueryFilter[] $filters
     */
    public function addFilters(array $filters): static
    {
        $this->filters = \array_merge($this->filters, $filters);
        return $this;
    }

    /**
     * Return's filter factory result
     * @return mixed
     */
    public function applyFilters(): QueryFilterFactory
    {
        $factory = $this->getFilterFactory();
        foreach ($this->filters as $key => $filter) {
            $factory->create($key, $filter);
        }

        return $factory;
    }
}
