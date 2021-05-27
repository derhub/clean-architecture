<?php

namespace Derhub\Shared\Model;

trait UseTimestampsWithSoftDelete
{
    use UseSoftDelete {
        UseSoftDelete::initSoftDelete as private _initSoftDelete;
    }
    use UseTimestamps {
        UseTimestamps::initTimestamps as private _initTimestamps;
    }

    protected function initTimestamps(): void
    {
        $this->_initTimestamps();
        $this->_initSoftDelete();
    }
}