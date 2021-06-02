<?php

namespace Tests\Template\Services\GetTemplates;

use Derhub\Template\AggregateExample\Model\Template;
use Derhub\Template\AggregateExample\Services\GetTemplates\GetTemplates;
use Derhub\Template\AggregateExample\Services\GetTemplates\GetTemplatesHandler;
use Derhub\Template\AggregateExample\Services\QueryResponse;
use Tests\Template\Services\ServiceTestCase;

class GetTemplatesTest extends ServiceTestCase
{
    protected function getHandler(): object
    {
        return new GetTemplatesHandler($this->queryRepo);
    }

    /**
     * @test
     */
    public function it_return_template_list(): void
    {
        $this->givenExisting(Template::class)
            ->when(
                new GetTemplates(
                    1,
                    100,
                    [$this->lastId->toString()],
                    'test'
                )
            )
            ->then(QueryResponse::class)
        ;
    }
}
