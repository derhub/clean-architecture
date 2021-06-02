<?php

namespace Derhub\Integration\TestUtils;

use Derhub\Integration\Mapper\ObjectMapper;
use Derhub\Shared\Message\Command\Command;
use Derhub\Shared\Message\Event\Event;
use Derhub\Shared\Message\MessageResponse;
use Derhub\Shared\Message\Query\Query;
use Derhub\Shared\Model\AggregateRepository;
use Derhub\Shared\Model\AggregateRoot;
use Derhub\Shared\Model\DomainEvent;
use Derhub\Shared\ModuleInterface;

abstract class MessageTestCase extends ModuleTestCase
{
    protected AggregateRepository $repository;
    protected ?AggregateRoot $lastAr;
    protected array $events;
    protected array $expectedExceptionErrors = [];
    protected array $extraExceptions = [];
    protected mixed $messageResponse;
    protected mixed $messageResponseType;
    protected ?array $fakeData;

    public function setUp(): void
    {
        parent::setUp();
        $this->messageResponse = null;
        $this->messageResponseType = null;
        $this->fakeData = null;

        $this->expectedExceptionErrors = [];
        $this->extraExceptions = [];

        $this->events = [];

        $this->lastAr = null;
        $this->repository = $this->getRepository();
        $this->repository->setCreatorId(
            function () {
                return $this->createId();
            }
        );

        $this->moduleService->register($this->getModule());
        $this->moduleService->start();
    }

    abstract protected function getModule(): ModuleInterface;

    abstract protected function createId(): object;

    abstract protected function getRepository(): mixed;

    protected function givenData($data): self
    {
        $this->fakeData = array_merge($this->fakeData ?? [], $data);
        return $this;
    }


    public function createAggregateRoot($class)
    {
        return new $class($this->createId());
    }

    public function given(string $aggregateRoot): self
    {
        $this->lastAr = $this->createAggregateRoot($aggregateRoot);
        return $this;
    }

    public function givenExisting(string $aggregateRoot): self
    {
        $this->given($aggregateRoot);
        $this->repository->save($this->lastAr);
        return $this;
    }

    public function givenAggregateRoot(AggregateRoot $aggregateRoot): self
    {
        $this->lastAr = $aggregateRoot;

        // make sure no events
        $aggregateRoot->pullEvents();
        return $this;
    }

    public function givenExistingAggregateRoot(
        AggregateRoot $aggregateRoot
    ): self {
        $this->repository->save($aggregateRoot);
        $this->lastAr = $aggregateRoot;

        // make sure no events
        $aggregateRoot->pullEvents();
        return $this;
    }

    protected function getDataFor($object): ?array
    {
        if ($this->fakeData === null && is_string($object)) {
            throw new \Exception(
                'No given data. '.
                'Its required when `when` param is string '.
                'You can set it using givenData(array $data) method'
            );
        }
        return $this->fakeData;
    }

    protected function createMessageFromData(string $str): object
    {
        $mapper = new ObjectMapper();
        return $mapper->transform($this->getDataFor($str), $str);
    }

    public function when(object ...$messages): self
    {
        foreach ($messages as $message) {
            $object = $message;

            // create message with given data
            if (is_string($message) && class_exists($message)) {
                $object = $this->createMessageFromData($message);
            }

            if ($message instanceof Event) {
                $this->eventBus->dispatch($object);
                $this->messageResponse = null;
            } elseif ($message instanceof Command) {
                $this->messageResponse =
                    $this->commandBus->dispatch($object);
            } else {
                $this->messageResponse =
                    $this->queryBus->dispatch($object);
            }

            if (is_object($this->messageResponse)) {
                $this->messageResponseType =
                    $this->messageResponse::class;
            } else {
                $this->messageResponseType = $this->messageResponse;
            }
        }

        return $this;
    }

    /**
     * Test Dispatch events
     * @param class-string<DomainEvent> ...$events
     */
    public function expectEvents(string ...$events): self
    {
        $this->events = $events;
        return $this;
    }

    public function expectExceptionErrors(string ...$errors): self
    {
        $this->expectedExceptionErrors = $errors;
        return $this;
    }

    /**
     * @param mixed $response
     */
    public function then(mixed $response): void
    {
        $exceptions = [];

        if ($this->messageResponse instanceof MessageResponse) {
            foreach ($this->messageResponse->errors() as $error) {
                /** @var \Exception $exception */
                $exception = $error['exception'] ?? null;
                if ($exception) {
                    $exceptions[] = $exception::class;
                    self::assertContains(
                        $exception::class, $this->expectedExceptionErrors,
                        'unexpected error: '.$error['message']
                    );
                }
            }
        }

        if (is_object($response)) {
            self::assertEquals($response, $this->messageResponse);
        } else {
//            self::assertEquals($response, $this->messageResponseType);
            self::assertTrue(
                is_a($this->messageResponseType, $response, true),
                sprintf(
                    'Failed asserting that %s is a %s',
                    $this->messageResponseType,
                    $response
                )
            );
        }
    }
}