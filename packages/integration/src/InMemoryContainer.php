<?php

namespace Derhub\Integration;

use Derhub\Shared\Container\ContainerInterface;

class InMemoryContainer implements ContainerInterface
{
    private array $container;

    public function __construct()
    {
        $this->container = [];
    }

    public function add($id, callable $classBuilder): void
    {
        $this->container[$id] = $classBuilder;
    }

    public function bind(string $class, mixed $abstract): self
    {
        return $this;
    }

    public function get(string $id)
    {
        if (! $this->has($id)) {
            throw new InMemoryContainerNotFoundException('not found '.$id);
        }

        return $this->container[$id];
    }

    public function has(string $id): bool
    {
        return isset($this->container[$id]);
    }

    public function resolve(string $class): mixed
    {
        return ($this->get($class))($this);
    }

    public function singleton(string $class, mixed $abstract): self
    {
        return $this;
    }
}
