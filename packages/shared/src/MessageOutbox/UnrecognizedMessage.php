<?php

namespace Derhub\Shared\MessageOutbox;

use Derhub\Shared\Exceptions\ApplicationException;
use Derhub\Shared\Message\Message;

class UnrecognizedMessage extends \Exception implements ApplicationException
{
    public static function fromMessageObj(Message $message): self
    {
        return new self(
            sprintf(
                'message %s is not command, query or event',
                $message::class,
            )
        );
    }
}