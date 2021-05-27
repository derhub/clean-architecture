<?php

namespace Derhub\Integration\MessageOutbox;

use Derhub\Shared\MessageOutbox\FailedToSaveMessageException;

class DoctrineFailedToSaveMessageException extends \Exception
    implements FailedToSaveMessageException
{
    public static function fromThrowable(\Throwable $e): self
    {
        return new self($e->getMessage(), $e->getCode(), $e);
    }
}