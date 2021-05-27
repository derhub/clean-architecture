<?php

namespace Derhub\Shared\Specification;

trait LeftRightTrait
{
    public function __construct(
        private SpecificationInterface $left,
        private SpecificationInterface $right
    ) {
    }

    public function left(): SpecificationInterface
    {
        return $this->left;
    }

    public function right(): SpecificationInterface
    {
        return $this->right;
    }
}
