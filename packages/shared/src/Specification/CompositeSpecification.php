<?php

namespace Derhub\Shared\Specification;

/**
 * @template T
 * @template-extends SpecificationInterface<T>
 */
interface CompositeSpecification extends SpecificationInterface
{
    public function and(SpecificationInterface $other): SpecificationInterface;

    public function not(SpecificationInterface $other): SpecificationInterface;
    public function or(SpecificationInterface $other): SpecificationInterface;
}
