<?php

namespace Derhub\Shared\Message\Query;

interface QueryResponse extends \Derhub\Shared\Message\MessageResponse
{
    public function results(): iterable;

    public function firstResult(): mixed;
}
