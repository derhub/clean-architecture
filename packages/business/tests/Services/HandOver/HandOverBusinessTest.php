<?php

namespace Tests\Business\Services\HandOver;

use Derhub\Business\Model\Business;
use Derhub\Business\Model\Values\Country;
use Derhub\Business\Model\Values\Name;
use Derhub\Business\Model\Values\OwnerId;
use Derhub\Business\Model\Values\Slug;
use Derhub\Business\Services\HandOver\HandOverBusiness;
use Derhub\Business\Services\HandOver\HandOverBusinessHandler;
use Derhub\Business\Services\HandOver\HandOverBusinessResponse;
use Derhub\Shared\Message\Command\CommandResponse;
use PHPUnit\Framework\TestCase;
use Tests\Business\Services\BaseServiceTestCase;

class HandOverBusinessTest extends BaseServiceTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->container->add(
            HandOverBusinessHandler::class,
            function () {
                return new HandOverBusinessHandler($this->repository);
            }
        );
    }

    /**
     * @test
     */
    public function it_hand_over_business(): void
    {
        $this->mockUniqueNameSpec->method('isSatisfiedBy')->willReturn(true);
        $this->mockUniqueSlugSpec->method('isSatisfiedBy')->willReturn(true);

        $model = new Business($this->lastId);
        $model->changeName(
            $this->mockUniqueNameSpec,
            Name::fromString('test')
        )
            ->changeSlug(
                $this->mockUniqueSlugSpec,
                Slug::fromString('test-d-ad-ad-ad')
            )
            ->transferOwnership(OwnerId::generate())
            ->changeCountry(Country::fromString('PH'))
        ;
        $this->givenExistingAggregateRoot($model)
            ->when(new HandOverBusiness($this->lastId->toString()))
            ->then(CommandResponse::class)
        ;
    }
}
