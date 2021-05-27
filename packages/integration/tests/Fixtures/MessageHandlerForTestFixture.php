<?php

namespace Tests\Integration\Fixtures;

class MessageHandlerForTestFixture
{
    private mixed $message;

    public function __invoke(mixed $msg): mixed
    {
        $this->message = $msg;
        
        return $this;
    }

    public function getMessage(): mixed
    {
        return $this->message;
    }
}