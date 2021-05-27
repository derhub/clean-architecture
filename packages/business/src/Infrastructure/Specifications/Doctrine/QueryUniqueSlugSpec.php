<?php

namespace Derhub\Business\Infrastructure\Specifications\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Derhub\Business\Infrastructure\Database\QueryBusinessRepository;
use Derhub\Business\Model\Specification\UniqueSlugSpec;

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
