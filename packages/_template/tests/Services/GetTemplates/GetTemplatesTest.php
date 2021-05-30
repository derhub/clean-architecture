<?php

namespace Tests\Template\Services\GetTemplates;

use Derhub\Template\Model\Template;
use Derhub\Template\Services\GetTemplates\GetTemplates;
use Derhub\Template\Services\GetTemplates\GetTemplatesHandler;
use Derhub\Template\Services\GetTemplates\GetTemplatesResponse;
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
            ->then(GetTemplatesResponse::class)
        ;
    }
}
