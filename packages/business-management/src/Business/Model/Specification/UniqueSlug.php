<?php

namespace Derhub\BusinessManagement\Business\Model\Specification;

use Derhub\BusinessManagement\Business\Model\Values\Slug;

class UniqueSlug
{
    public function __construct(private Slug $slug)
    {
    }

    public function slug(): Slug
    {
        return $this->slug;
    }
}
