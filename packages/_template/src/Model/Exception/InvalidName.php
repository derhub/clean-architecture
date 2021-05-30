<?php

namespace Derhub\Template\Model\Exception;

use Derhub\Shared\Exceptions\DomainException;

use function sprintf;

class InvalidName extends \Exception implements DomainException
{

    public static function notUnique(
        \Derhub\Template\Model\Values\Name $name
    ): self {
        return new self(
            sprintf('%s is not unique', (string)$name),
        );
    }
}