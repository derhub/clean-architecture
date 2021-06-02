<?php

namespace Derhub\Template\AggregateExample\Model\Specification;

use Derhub\Template\AggregateExample\Model\Values\Name;

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
