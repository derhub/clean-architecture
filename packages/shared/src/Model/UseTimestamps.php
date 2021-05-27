<?php

namespace Derhub\Shared\Model;

use Derhub\Shared\Values\DateTimeLiteral;

trait UseTimestamps
{
    private DateTimeLiteral $createdAt;
    private DateTimeLiteral $updatedAt;

    protected function initTimestamps(): void
    {
        $this->createdAt = new DateTimeLiteral();
        $this->updatedAt = new DateTimeLiteral();
    }
}