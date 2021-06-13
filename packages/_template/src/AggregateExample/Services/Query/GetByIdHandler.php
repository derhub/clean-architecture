<?php

namespace Derhub\Template\AggregateExample\Services\Query;

use Derhub\Shared\Message\Query\QueryResponse;
use Derhub\Template\AggregateExample\Services\CommonQueryResponse;

class GetByIdHandler
{
    public function __invoke(): QueryResponse
    {
        return new CommonQueryResponse();
    }
}