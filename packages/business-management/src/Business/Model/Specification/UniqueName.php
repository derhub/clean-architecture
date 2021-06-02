<?php

namespace Derhub\BusinessManagement\Business\Model\Specification;

use Derhub\BusinessManagement\Business\Model\Values\Name;

class UniqueName
{
    public function __construct(
        private Name $name,
    ) {
    }
    public function name(): Name
    {
        return $this->name;
    }
}
