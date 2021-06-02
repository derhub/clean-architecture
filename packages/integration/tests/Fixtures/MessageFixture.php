<?php

namespace Tests\Integration\Fixtures;

class MessageFixture
{
    public function aggregateRootId(): ?string
    {
        return null;
    }

    public function version(): int
    {
        return 1;
    }

    public function __construct(
        private SimpleValueObjFixture $param1,
        private string $param2,
    ) {
    }

    public function param1(): SimpleValueObjFixture
    {
        return $this->param1;
    }

    public function param2(): string
    {
        return $this->param2;
    }
}
