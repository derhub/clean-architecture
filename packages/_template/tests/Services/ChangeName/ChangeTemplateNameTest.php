<?php

namespace Tests\Template\Services\ChangeName;

use Derhub\Shared\Message\Command\CommandResponse;
use Derhub\Template\Model\Exception\InvalidName;
use Derhub\Template\Model\Specification\UniqueNameSpec;
use Derhub\Template\Model\Template;
use Derhub\Template\Services\ChangeName\ChangeTemplateName;
use Derhub\Template\Services\ChangeName\ChangeTemplateNameHandler;
use Tests\Template\Services\ServiceTestCase;

class ChangeTemplateNameTest extends ServiceTestCase
{
    /**
     * @var \Derhub\Template\Model\Specification\UniqueNameSpec|\PHPUnit\Framework\MockObject\MockObject
     */
    private UniqueNameSpec|\PHPUnit\Framework\MockObject\MockObject $nameSpecMock;

    public function setUp(): void
    {
        $this->nameSpecMock = $this->createMock(UniqueNameSpec::class);
        parent::setUp();
    }

    protected function getHandler(): object
    {
        return new ChangeTemplateNameHandler(
            $this->repository,
            $this->nameSpecMock,
        );
    }

    /**
     * @test
     */
    public function it_can_change_name(): void
    {
        $this->nameSpecMock
            ->method('isSatisfiedBy')
            ->willReturn(true)
        ;

        $this->givenExisting(Template::class)
            ->when(
                new ChangeTemplateName(
                    $this->lastId->toString(),
                    'test'
                )
            )
            ->then(CommandResponse::class)
        ;
    }

    /**
     * @test
     */
    public function it_fails_when_name_is_not_unique(): void
    {
        $this->nameSpecMock
            ->method('isSatisfiedBy')
            ->willReturn(false)
        ;

        $this->givenExisting(Template::class)
            ->when(
                new ChangeTemplateName(
                    $this->lastId->toString(),
                    'test'
                )
            )
            ->expectExceptionErrors(InvalidName::class)
            ->then(CommandResponse::class)
        ;
    }
}
