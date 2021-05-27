<?php

namespace Derhub\Shared\Message\Query;

use Derhub\Shared\Message\AbstractMessageResponse;

abstract class AbstractQueryResponse extends AbstractMessageResponse implements QueryResponse
{
    public function firstResult(): mixed
    {
        foreach ($this->result() as $item) {
            return $item;
        }
    }
}