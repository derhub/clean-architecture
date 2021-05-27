<?php

namespace Tests\Business\Services\Enable;

use Derhub\Business\Model\Business;
use Derhub\Business\Services\Enable\EnableBusiness;
use Derhub\Business\Services\Enable\EnableBusinessHandler;
use Derhub\Business\Services\Enable\EnableBusinessResponse;
use Tests\Business\Services\BaseServiceTestCase;

class EnableBusinessTest extends BaseServiceTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->container->add(
            EnableBusinessHandler::class,
            function () {
                return new EnableBusinessHandler($this->repository);
            }
        );
    }

    /**
     * @test
     */
    public function it_enable_business(): void
    {
        $this->givenExisting(Business::class)
            ->when(new EnableBusiness($this->lastId->toString()))
            ->then(EnableBusinessResponse::class)
        ;
    }
}
