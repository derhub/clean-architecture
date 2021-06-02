<?php

namespace Derhub\Shared\Message\Query;

interface QueryResponse extends \Derhub\Shared\Message\MessageResponse
{
    public function firstResult(): mixed;
    public function results(): iterable;
}
