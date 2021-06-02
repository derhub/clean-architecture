<?php

namespace Derhub\Template\AggregateExample\Model\Exception;

use Derhub\Shared\Exceptions\DomainException;

use function sprintf;

class InvalidName extends \Exception implements DomainException
{
    public static function notUnique(
        \Derhub\Template\AggregateExample\Model\Values\Name $name
    ): self {
        return new self(
            sprintf('%s is not unique', (string)$name),
        );
    }
}
