<?php

declare(strict_types=1);

namespace EB\Template\Model\Exception;

use EB\Shared\Exceptions\DomainException;

final class SampleDomainEvent extends \Exception implements DomainException
{
    public static function fromTemplate(): self
    {
        return new self('this is just sample');
    }
}