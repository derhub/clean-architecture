<?php

namespace Derhub\Shared\Module;

use Derhub\Shared\Message\MessageName;

interface ModuleInterface
{
    public const DEPENDENCY_BIND = 'bind';
    public const DEPENDENCY_SINGLETON = 'singleton';
    public const SERVICE_COMMANDS = MessageName::COMMAND;
    public const SERVICE_QUERIES = MessageName::QUERY;
    public const SERVICE_EVENTS = MessageName::EVENT;
    public const SERVICE_LISTENERS = 'listeners';

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
