<?php

namespace Derhub\Shared\Integrations\Laravel;

use Derhub\Shared\Container\ContainerInterface;

class LaravelContainer implements ContainerInterface
{
    public function __construct(private \Illuminate\Contracts\Container\Container $laravel)
    {
    }

    public function get(string $id): mixed
    {
        return $this->laravel->get($id);
    }

    public function has(string $id): bool
    {
        return $this->laravel->has($id);
    }

    public function resolve(string $class): mixed
    {
        return $this->laravel->make($class);
    }
}