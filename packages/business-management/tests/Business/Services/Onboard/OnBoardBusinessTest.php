<?php

namespace Tests\BusinessManagement\Business\Services\Onboard;

use Derhub\BusinessManagement\Business\Model\Business;
use Derhub\BusinessManagement\Business\Model\Exception\NameAlreadyExist;
use Derhub\BusinessManagement\Business\Model\Exception\SlugExistException;
use Derhub\BusinessManagement\Business\Model\Values\OnBoardStatus;
use Derhub\BusinessManagement\Business\Model\Values\OwnerId;
use Derhub\BusinessManagement\Business\Services\Onboard\OnBoardBusiness;
use Derhub\BusinessManagement\Business\Services\Onboard\OnBoardBusinessHandler;
use Derhub\BusinessManagement\Business\Services\Onboard\OnBoardBusinessResponse;
use Tests\BusinessManagement\Business\Services\BaseServiceTestCase;

class OnBoardBusinessTest extends BaseServiceTestCase
{
    /**
     * @test
     */
    public function it_fails_when_name_is_not_unique(): void
    {
        $this->mockUniqueNameSpec->method('isSatisfiedBy')->willReturn(false);
        $this->mockUniqueSlugSpec->method('isSatisfiedBy')->willReturn(true);

        $this->prepareTest()
            ->expectExceptionErrors(NameAlreadyExist::class)
            ->then(OnBoardBusinessResponse::class)
        ;
    }

    /**
     * @test
     */
    public function it_fails_when_slug_is_not_unique(): void
    {
        $this->mockUniqueNameSpec->method('isSatisfiedBy')->willReturn(true);
        $this->mockUniqueSlugSpec->method('isSatisfiedBy')->willReturn(false);

        $this->prepareTest()
            ->expectExceptionErrors(SlugExistException::class)
            ->then(OnBoardBusinessResponse::class)
        ;
    }
    /**
     * @test
     */
    public function it_onboard_business(): void
    {
        $this->mockUniqueNameSpec->method('isSatisfiedBy')->willReturn(true);
        $this->mockUniqueSlugSpec->method('isSatisfiedBy')->willReturn(true);

        $this->prepareTest()
            ->then(OnBoardBusinessResponse::class)
        ;
    }

    public function prepareTest(): self
    {
        return $this->given(Business::class)
            ->when(
                new OnBoardBusiness(
                    name: 'test',
                    ownerId: OwnerId::generate()->toString(),
                    slug: 's-d-f-g',
                    country: 'PH',
                    onboardStatus: OnBoardStatus::byOwner()->toString(),
                )
            )
            ;
    }
    protected function getHandler(): object
    {
        return new OnBoardBusinessHandler(
            $this->repository,
            $this->mockUniqueNameSpec,
            $this->mockUniqueSlugSpec,
        );
    }
}
