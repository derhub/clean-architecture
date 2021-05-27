<?php

namespace Derhub\Business\Model\Specification;

use Derhub\Business\Model\Values\Name;
use Derhub\Business\Model\Values\OwnerId;

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