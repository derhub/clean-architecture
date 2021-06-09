<?php

namespace Derhub\Shared\Message;

use Derhub\Shared\Message\MessageName;
use Derhub\Shared\Message\Command\CommandListenerProvider;
use Derhub\Shared\Message\Event\EventListenerProvider;
use Derhub\Shared\Message\Query\QueryListenerProvider;
use Derhub\Shared\Utils\Assert;

final class MessageListenerProviderRegister
{
    public const COMMAND = MessageName::COMMAND;
    public const QUERY = MessageName::QUERY;
    public const EVENT = MessageName::EVENT;

    public function __construct(
        private EventListenerProvider $eventListener,
        private CommandListenerProvider $commandListener,
        private QueryListenerProvider $queryListener,
    ) {
    }

    public function byName(
        string $type,
        string $name,
        string|array $handler,
    ): self {
        if ($type === self::EVENT) {
            $this->eventListener->addHandlerByName($name, (array)$handler);
            return $this;
        }

        $this->verifyForSingleHandler($handler);

        if ($type === self::COMMAND) {
            $this->commandListener->addHandlerByName($name, $handler);
            return $this;
        }

        if ($type === self::QUERY) {
            $this->queryListener->addHandlerByName($name, $handler);
            return $this;
        }

        return $this;
    }

    public function byObject(
        string $type,
        string $moduleId,
        string $messageObject,
        string|array|null $handler
    ): self {
        $name = MessageName::for($moduleId, $type, $messageObject);
        if ($type === self::EVENT) {
            $this->eventListener->addHandler(
                $name, $messageObject, $handler ?? []
            );
            return $this;
        }

        $this->verifyForSingleHandler($handler);
        if ($type === self::COMMAND) {
            $this->commandListener->addHandler($name, $messageObject, $handler);
            return $this;
        }

        if ($type === self::QUERY) {
            $this->queryListener->addHandler($name, $messageObject, $handler);
            return $this;
        }

        return $this;
    }

    public function byNameOrObject(
        string $type,
        string $moduleId,
        string $message,
        string|array|null $handler
    ): self {
        if (\class_exists($message)) {
            $this->byObject($type, $moduleId, $message, $handler);
        } else {
            $this->byName($type, $message, $handler);
        }
        return $this;
    }

    public function query(
        string $moduleId,
        string $message,
        string|array|null $handler
    ): self {
        $this->byNameOrObject(self::QUERY, $moduleId, $message, $handler);
        return $this;
    }

    public function command(
        string $moduleId,
        string $message,
        string|array|null $handler
    ): self {
        $this->byNameOrObject(self::COMMAND, $moduleId, $message, $handler);
        return $this;
    }

    public function event(
        string $moduleId,
        string $message,
        string|array|null $handler
    ): self {
        $this->byNameOrObject(self::EVENT, $moduleId, $message, $handler);
        return $this;
    }

    private function verifyForSingleHandler(
        array|string|null $handler
    ): void {
        Assert::notNull(
            $handler, 'handler is required when type is command or query'
        );
    }
}