<?php

namespace Derhub\Business\Model\Specification;

use Derhub\Business\Model\Values\Slug;

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