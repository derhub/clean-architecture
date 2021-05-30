<?php

namespace Derhub\Business\Infrastructure\Specifications;

use Derhub\Business\Infrastructure\Database\QueryBusinessRepository;
use Derhub\Business\Model\Specification\UniqueNameSpec;

class QueryUniqueNameSpec implements UniqueNameSpec
{
    public function __construct(private QueryBusinessRepository $repository)
    {
    }

    public function isSatisfiedBy(object $by): bool
    {
        return $this->repository->exists('name', $by->name()->toString());
    }
}