<?php

namespace Derhub\Shared;

interface ModuleInterface
{
    public function getId(): string;

    public function getServices(): array;

    public function start(): void;
}
