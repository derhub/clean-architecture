<?php

namespace Derhub\Integration\MessageBus;

use Derhub\Shared\ObjectMapper\ObjectMapperInterface;

class MessageAssemblerImpl implements MessageAssembler
{
    private array $factories;

    public function __construct(private ObjectMapperInterface $objectMapper)
    {
        $this->factories = [];
    }

    public function add(string $className, mixed $mapper): void
    {
        $this->factories[$className] = $mapper;
    }

    public function has(string $className): bool
    {
        return isset($this->factories[$className]);
    }

    public function get(string $className): mixed
    {
        return $this->factories[$className] ?? null;
    }

    /**
     * @param class-string $messageClass
     * @param object|array $data
     * @return object
     */
    public function transform(
        string $messageClass,
        object|array $data
    ): object {
        $factory = $this->get($messageClass)
            ?? [$this->objectMapper, 'transform'];

        return call_user_func($factory, $data, $messageClass);
    }
}