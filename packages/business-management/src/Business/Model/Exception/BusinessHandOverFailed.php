<?php

namespace Derhub\BusinessManagement\Business\Model\Exception;

use Derhub\Shared\Exceptions\DomainException;

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
