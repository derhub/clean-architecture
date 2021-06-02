<?php

namespace Derhub\BusinessManagement\Business\Model\Exception;

use Derhub\BusinessManagement\Business\Model\Values\Slug;
use Derhub\Shared\Exceptions\DomainException;

class SlugAlreadyExist extends \Exception implements DomainException
{
    public static function fromSlug(Slug $slug): self
    {
        return new self(
            sprintf('%s already exists', (string)$slug)
        );
    }
}
