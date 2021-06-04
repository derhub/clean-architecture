<?php

namespace Derhub\Shared\Model;

interface Entity
{
    public function sameAs(Entity $other): bool;
}
