<?php

namespace Derhub\Business\Services\Exception;

use Derhub\Business\Model\Values\BusinessId;
use Derhub\Shared\Exceptions\ApplicationException;

class BusinessNotFound extends \InvalidArgumentException implements ApplicationException
{
    public static function fromId(BusinessId $id): self
    {
        return new self(sprintf('%s not found', (string)$id));
    }
}
