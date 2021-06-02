<?php

namespace Derhub\Shared\Message;

abstract class AbstractMessageResponse implements MessageResponse
{
    private array $errors;
    private array $warnings;

    public function __construct()
    {
        $this->errors = [];
        $this->warnings = [];
    }

    public function addError(
        string $type,
        string $message,
        ?\Throwable $e = null
    ): self {
        $this->errors[] = [
            'type' => $type,
            'message' => $message,
        ];

        return $this;
    }

    public function addErrorFromException(\Throwable $e): self
    {
        $this->errors[] = [
            'type' => $e::class,
            'message' => $e->getMessage(),
            'exception' => $e,
        ];

        return $this;
    }

    public function addWarning(
        string $type,
        string $message,
    ): self {
        $this->warnings[] = [
            'type' => $type,
            'message' => $message,
        ];

        return $this;
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function isFailed(): bool
    {
        return ! $this->isSuccess();
    }

    public function isSuccess(): bool
    {
        return empty($this->errors());
    }

    public function warning(): array
    {
        return $this->warnings;
    }
}
