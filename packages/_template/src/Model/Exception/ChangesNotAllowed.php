<?php

namespace Derhub\Template\Model\Exception;

use Derhub\Shared\Exceptions\DomainException;

final class ChangesNotAllowed extends \Exception implements DomainException
{
    public static function whenDeleted(): self
    {
        return new self('changing the state of deleted template is not allowed');
    }
}