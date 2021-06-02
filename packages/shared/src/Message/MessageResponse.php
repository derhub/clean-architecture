<?php

namespace Derhub\Shared\Message;

interface MessageResponse
{
    public function errors(): array;

    public function isFailed(): bool;

    public function isSuccess(): bool;

    public function warning(): array;
}
