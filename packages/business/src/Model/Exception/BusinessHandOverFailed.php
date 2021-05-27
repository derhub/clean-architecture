<?php

namespace Derhub\Business\Model\Exception;

use Derhub\Business\Model\Business;
use Derhub\Business\Model\Values\Name;
use Derhub\Shared\Exceptions\DomainException;
use Derhub\Shared\ValueObject\UserId;

class BusinessHandOverFailed extends \Exception implements DomainException
{
    public static function alreadyHanded(): self
    {
        return new self('Business is already handed');
    }

    public static function ownerIdRequired()
    {
        return new self(
            'Owner id is required',
        );
    }

    public static function slugRequired(): self
    {
        return new self(
            'Slug is required before hand over',
        );
    }
}
