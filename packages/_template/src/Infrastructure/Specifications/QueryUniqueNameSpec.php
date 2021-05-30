<?php

namespace Derhub\Template\Infrastructure\Specifications;

use Derhub\Template\Infrastructure\Database\TemplateQueryRepository;
use Derhub\Template\Model\Specification\UniqueNameSpec;

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