<?php

namespace Derhub\Shared\Query;

trait QueryItemMapperRepositoryCapabilities
{
    protected ?QueryItemMapper $mapper = null;

    public function setMapper(QueryItemMapper $mapper): void
    {
        $this->mapper = $mapper;
    }

    protected function mapResult(array $data): QueryItem|array
    {
        return $this->mapper?->fromArray($data) ?? $data;
    }
}