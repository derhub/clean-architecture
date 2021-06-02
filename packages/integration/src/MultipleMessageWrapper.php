<?php

namespace Derhub\Integration;

class MultipleMessageWrapper
{
    public function __construct(private array $messages)
    {
    }

    public function messages(): array
    {
        return $this->messages;
    }
}
