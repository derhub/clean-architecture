<?php

namespace Derhub\Template\Shared;

use Derhub\Shared\Exceptions\ApplicationException;
use Derhub\Shared\Message\Command\CommandResponse;

class FailedCommandException extends \Exception
    implements ApplicationException
{
    private ?CommandResponse $response = null;

    public static function fromResponse(CommandResponse $response): self
    {
        $firstError = $response->errors()[0];
        $self = new self($firstError['message'], 0, $firstError['exception']);
        $self->response = $response;

        return $self;
    }

    public function response(): ?CommandResponse
    {
        return $this->response;
    }
}