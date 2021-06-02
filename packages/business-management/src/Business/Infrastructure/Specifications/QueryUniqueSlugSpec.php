<?php

namespace Derhub\BusinessManagement\Business\Infrastructure\Specifications;

use Derhub\BusinessManagement\Business\Infrastructure\Database\QueryBusinessRepository;
use Derhub\BusinessManagement\Business\Model\Specification\UniqueSlugSpec;

class QueryUniqueSlugSpec implements UniqueSlugSpec
{
    public function __construct(private QueryBusinessRepository $repository)
    {
    }

    public function isSatisfiedBy(object $by): bool
    {
        return $this->repository->exists('slug', $by->slug()->toString());
    }
}
