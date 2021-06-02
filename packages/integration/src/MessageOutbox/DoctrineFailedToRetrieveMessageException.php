<?php

namespace Derhub\Integration\MessageOutbox;

use Derhub\Shared\MessageOutbox\Exceptions\RecordMessageFailException;

class DoctrineFailedToRetrieveMessageException extends \Exception implements RecordMessageFailException
{
    public static function fromThrowable(\Throwable $e): self
    {
        return new self($e->getMessage(), $e->getCode(), $e);
    }
}
