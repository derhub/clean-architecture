<?php

namespace Derhub\Shared\Message;

interface MessageResponse
{
    public function aggregate(): string;

    public function errors(): array;

    public function warning(): array;

    public function isSuccess(): bool;

    public function isFailed(): bool;

}