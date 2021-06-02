<?php

namespace Derhub\Integration\LaravelEventBus;

use Derhub\Shared\Container\ContainerInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class EventConsumer implements ShouldQueue
{
    use InteractsWithQueue;
    use Queueable;

    private string $handler;
    private object $message;

    /**
     * @param class-string $handler
     * @param string $messageName
     * @param object $message
     */
    public function __construct(
        string $handler,
        string $messageName,
        object $message
    ) {
        $this->handler = $handler;
        $this->message = $message;

//        [$moduleId] = explode('.', $messageName);
//        $this->onQueue('module_'.$moduleId);
    }

    public function __invoke(ContainerInterface $container): void
    {
        $handle = $container->resolve($this->handler);
        $handle($this->message);
    }
}
