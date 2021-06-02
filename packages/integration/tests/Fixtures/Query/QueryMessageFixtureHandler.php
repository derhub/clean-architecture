<?php

namespace Tests\Integration\Fixtures\Query;

use Derhub\Shared\Message\Query\QueryResponse;
use Tests\Integration\Fixtures\MessageHandlerForTestFixture;

class QueryMessageFixtureHandler extends MessageHandlerForTestFixture
{
    public function __invoke(mixed $msg): QueryResponse
    {
        return new QueryResponseFixture($msg);
    }
}
