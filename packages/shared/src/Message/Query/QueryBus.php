<?php

namespace Derhub\Shared\Message\Query;

use Derhub\Shared\Message\DispatcherInterface;

interface QueryBus extends DispatcherInterface
{
    /**
     * @param \Derhub\Shared\Message\Query\Query ...$message
     * @return \Derhub\Shared\Message\Query\QueryResponse|array|null
     */
    public function dispatch(Query ...$message): null|QueryResponse|array;
}
