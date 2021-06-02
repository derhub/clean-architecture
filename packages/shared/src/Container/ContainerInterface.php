<?php

namespace Derhub\Shared\Container;

interface ContainerInterface extends \Psr\Container\ContainerInterface
{
    /**
     * Create class
     *
     * @param string $class
     * @return mixed
     */
    public function resolve(string $class): mixed;

    public function bind(string $class, mixed $abstract): mixed;

    public function singleton(string $class, mixed $abstract): mixed;
}
