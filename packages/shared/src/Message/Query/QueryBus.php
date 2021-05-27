<?php

namespace Derhub\Shared\Message\Query;

use Derhub\Shared\Message\DispatcherInterface;

interface QueryBus extends DispatcherInterface
{
    /**
     * @param \Derhub\Shared\Message\Query\Query ...$message
     * @return \Derhub\Shared\Message\Query\QueryResponse[]|\Derhub\Shared\Message\Query\QueryResponse
     */
    public function dispatch(Query ...$message): QueryResponse|array;
}
