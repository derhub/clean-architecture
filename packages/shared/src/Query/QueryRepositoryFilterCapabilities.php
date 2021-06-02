<?php

namespace Derhub\Shared\Query;

use function array_merge;

trait QueryRepositoryFilterCapabilities
{
    protected ?QueryFilterFactory $filterFactory = null;
    protected array $filters = [];

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
        $this->filters = array_merge($this->filters, $filters);

        return $this;
    }

    /**
     * Return's filter factory result
     * @return mixed
     */
    public function applyFilters(): mixed
    {
        $lastFilterFactoryResult = null;
        foreach ($this->filters as $key => $filter) {
            $lastFilterFactoryResult = $this->filterFactory->create($key, $filter);
        }

        return $lastFilterFactoryResult;
    }

    protected function setFilterFactory(QueryFilterFactory $filterFactory): void
    {
        $this->filterFactory = $filterFactory;
    }
}
