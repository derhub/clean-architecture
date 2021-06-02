<?php

namespace Derhub\Integration\MessageOutbox;

use Derhub\Shared\MessageOutbox\Exceptions\FailedToRetrieve;

class DoctrineFailedToSaveMessageException extends \Exception implements FailedToRetrieve
{
    public static function fromThrowable(\Throwable $e): self
    {
        return new self($e->getMessage(), $e->getCode(), $e);
    }
}
