<?php

namespace Derhub\Shared\Module;

interface ModuleInterface
{
    public const DEPENDENCY_BIND = 'bind';
    public const DEPENDENCY_SINGLETON = 'singleton';
    public const SERVICE_COMMANDS = 'commands';
    public const SERVICE_EVENTS = 'events';
    public const SERVICE_LISTENERS = 'listeners';
    public const SERVICE_QUERIES = 'queries';

    public const INITIAL_SERVICES = [
        self::DEPENDENCY_BIND => [],
        self::DEPENDENCY_SINGLETON => [],
        self::SERVICE_COMMANDS => [],
        self::SERVICE_QUERIES => [],
        self::SERVICE_EVENTS => [],
        self::SERVICE_LISTENERS => [],
    ];

    public function getId(): string;

    public function services(): array;

    public function start(): void;
}
