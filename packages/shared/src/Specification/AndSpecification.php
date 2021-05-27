<?php

namespace Derhub\Shared\Specification;

class AndSpecification implements SpecificationInterface
{
    use LeftRightTrait;

    public function isSatisfiedBy(mixed $by): bool
    {
        return $this->left()->isSatisfiedBy($by)
            && $this->right()->isSatisfiedBy($by);
    }
}
