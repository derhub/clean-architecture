<?php

namespace Derhub\Integration;

use Derhub\Shared\Exceptions\LayeredException;

class MissingHandlerException extends \Exception implements LayeredException
{
    public static function forMessage(string $message)
    {
        return new self(
            sprintf('Missing handler for message %s', $message)
        );
    }
}
