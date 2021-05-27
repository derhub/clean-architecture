<?php

namespace Derhub\Integration\MessageOutbox;

use Derhub\Shared\MessageOutbox\FailedToRetrieveMessageException;

class DoctrineFailedToRetrieveMessageException extends \Exception implements FailedToRetrieveMessageException
{
    public static function fromThrowable(\Throwable $e): self
    {
        return new self($e->getMessage(), $e->getCode(), $e);
    }
}