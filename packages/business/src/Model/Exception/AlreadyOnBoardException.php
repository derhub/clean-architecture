<?php

namespace Derhub\Business\Model\Exception;

use Derhub\Shared\Exceptions\DomainException;

class AlreadyOnBoardException extends \Exception implements DomainException
{

    public static function fromOnboard(): self
    {
        return new self('business already onboarded');
    }

    public static function fromOnboardStatus(
        \Derhub\Business\Model\Values\OnBoardStatus $onBoardStatus
    ) {
        return new self((string)$onBoardStatus);
    }
}