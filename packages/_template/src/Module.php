<?php

namespace EB\Template;

use EB\Template\Model\Event\TemplateSampleEvent;
use EB\Template\Process\SampleEventListener;

class Module implements \EB\Shared\ModuleInterface
{
    public const ID = 'template';

    public function getId(): string
    {
        return self::ID;
    }

    public function getServices(): array
    {
        return [
            'commands' => [
                \EB\Template\Services\SampleCommand\SampleCommand::class => \EB\Template\Services\SampleCommand\SampleCommandHandler::class,
            ],
            'queries' => [
                \EB\Template\Services\SampleQuery\SampleQuery::class => \EB\Template\Services\SampleQuery\SampleQueryHandler::class,
            ],
            'events' => [
                TemplateSampleEvent::class,
            ],
            'listeners' => [
                self::ID.'.event.TemplateSampleEvent' => [
                    SampleEventListener::class,
                ],
            ],
        ];
    }

    public function start(): void
    {
        // TODO: Implement start() method.
    }
}