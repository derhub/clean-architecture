<?php

namespace Derhub\Shared\Specification;

/**
 * @template T
 */
interface SpecificationInterface
{
    /**
     * @param T $by
     * @return bool
     */
    public function isSatisfiedBy(object $by): bool;
}
