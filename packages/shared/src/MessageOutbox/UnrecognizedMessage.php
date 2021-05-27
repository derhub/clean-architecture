<?php

namespace Derhub\Shared\MessageOutbox;

use Derhub\Shared\Exceptions\DomainException;
use Derhub\Shared\Message\Message;

class UnrecognizedMessage extends DomainException
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