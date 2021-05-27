<?php

namespace Derhub\Integration\Laravel;

use Derhub\Shared\Container\ContainerInterface;

class LaravelContainer implements ContainerInterface
{
    /**
     * @var callable():\Illuminate\Contracts\Container\Container
     */
    private $laravel;
    public function __construct(callable $laravel)
    {
        $this->laravel = $laravel;
    }

    public function get(string $id): mixed
    {
        return ($this->laravel)()->get($id);
    }

    public function has(string $id): bool
    {
        return ($this->laravel)()->has($id);
    }

    public function resolve(string $class): mixed
    {
        return ($this->laravel)()->make($class);
    }
}