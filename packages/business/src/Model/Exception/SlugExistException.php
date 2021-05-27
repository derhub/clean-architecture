<?php

namespace Derhub\Business\Model\Exception;

use Derhub\Business\Model\Values\Slug;
use Derhub\Shared\Exceptions\DomainException;

class SlugExistException extends \Exception implements DomainException
{
    public static function fromSlug(Slug $slug): self
    {
        return new self(
            sprintf('%s already exists', (string)$slug)
        );
    }
}