<?php

namespace Derhub\Shared\Model;

use Derhub\Shared\Values\DateTimeLiteral;

trait UseSoftDelete
{
    private DateTimeLiteral $deletedAt;

    protected function initSoftDelete(): void
    {
        $this->deletedAt = new DateTimeLiteral();
    }
}
