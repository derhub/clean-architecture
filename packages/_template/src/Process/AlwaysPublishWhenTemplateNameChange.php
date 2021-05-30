<?php

namespace Derhub\Template\Process;

use Derhub\Shared\Message\Command\CommandBus;
use Derhub\Template\Model\Event\TemplateNameChanged;
use Derhub\Template\Services\Publish\PublishTemplate;
use Derhub\Template\Shared\FailedCommandException;

class AlwaysPublishWhenTemplateNameChange
{
    public function __construct(
        private CommandBus $commandBus
    ) {
    }

    public function __invoke(TemplateNameChanged $e): void
    {
        $response = $this->commandBus->dispatch(
            new PublishTemplate($e->aggregateRootId())
        );

        if (! $response->isSuccess()) {
            throw FailedCommandException::fromResponse($response);
        }
    }
}