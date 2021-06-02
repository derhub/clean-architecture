<?php

namespace Derhub\Template\AggregateExample\Infrastructure\Specifications;

use Derhub\Template\AggregateExample\Infrastructure\Database\TemplateQueryRepository;
use Derhub\Template\AggregateExample\Model\Specification\UniqueNameSpec;

class QueryUniqueNameSpec implements UniqueNameSpec
{
    public function __construct(private TemplateQueryRepository $repository)
    {
    }

    public function isSatisfiedBy(object $by): bool
    {
        return $this->repository->exists('name', $by->name()->toString());
    }
}
