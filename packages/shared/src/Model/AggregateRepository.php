<?php

namespace Derhub\Shared\Model;

interface AggregateRepository
{
    public function getNextId(): mixed;
}
