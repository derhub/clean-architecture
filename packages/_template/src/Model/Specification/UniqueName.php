<?php

namespace Derhub\Template\Model\Specification;

use Derhub\Template\Model\Values\Name;
use Derhub\Template\Model\Values\OwnerId;

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