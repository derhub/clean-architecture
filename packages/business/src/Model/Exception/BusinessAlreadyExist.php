<?php

namespace Derhub\Business\Model\Exception;

use Derhub\Business\Model\Values\Name;
use Derhub\Business\Model\Values\Slug;
use Derhub\Shared\Exceptions\DomainException;
use Derhub\Shared\Model\AggregateRoot;

class BusinessAlreadyExist extends \Exception implements DomainException
{
    public static function withName(
        Name $name
    ): self {
        return new self(
            sprintf('business `%s` already exist', (string)$name)
        );
    }

    public static function fromSlug(
        AggregateRoot $aggregateRoot,
        Slug $slug
    ) {
        $self = new self(
            sprintf('business slug `%s` already exist', (string)$slug)
        );
        $self->aggregateRoot = $aggregateRoot;

        return $self;
    }
}
