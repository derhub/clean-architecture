<?php

namespace Derhub\Integration\TestUtils;

use Derhub\Integration\InMemoryContainer;
use Derhub\Integration\Mapper\SimpleMapper;
use Derhub\Integration\MessageBus\MessageAssemblerImpl;
use Derhub\Integration\MessageBus\MessageBus;
use Derhub\Integration\MessageBus\MessageBusFacade;
use Derhub\Integration\MessageBus\MessageRouteFactory;
use Derhub\Integration\MessageOutbox\JMSMessageSerializer;
use Derhub\Integration\ModuleService\MessageNameResolver;
use Derhub\Integration\ModuleService\ModuleListImpl;
use Derhub\Integration\ModuleService\ModuleService;
use Derhub\Integration\ModuleService\ModuleServiceImpl;
use Derhub\Integration\TacticianBus\Locator\CmdLocator;
use Derhub\Integration\TacticianBus\Locator\EventLocator;
use Derhub\Integration\TacticianBus\Locator\QueryLocator;
use Derhub\Integration\TacticianBus\MessageBusFactory;
use Derhub\Shared\Container\ContainerInterface;
use Derhub\Shared\Message\Command\CommandBus;
use Derhub\Shared\Message\Command\CommandListenerProvider;
use Derhub\Shared\Message\Event\EventBus;
use Derhub\Shared\Message\Event\EventListenerProvider;
use Derhub\Shared\Message\Query\QueryBus;
use Derhub\Shared\Message\Query\QueryListenerProvider;
use Derhub\Shared\MessageOutbox\InMemoryOutboxRepository;
use Derhub\Shared\MessageOutbox\MessageOutboxObjectWrapperFactory;
use Derhub\Shared\MessageOutbox\MessageSerializer;
use Derhub\Shared\MessageOutbox\OutboxRepository;
use Derhub\Shared\MessageOutbox\SimpleSerializer;
use PHPUnit\Framework\TestCase;

class ModuleTestCase extends TestCase
{
    protected ContainerInterface $container;
    protected CommandListenerProvider $commandProvider;
    protected QueryListenerProvider $queryProvider;
    protected CommandBus $commandBus;
    protected QueryBus $queryBus;
    protected SimpleMapper $mapper;
    protected MessageBus $messageBus;
    protected MessageAssemblerImpl $assembler;
    protected ModuleListImpl $moduleList;
    protected ModuleService $moduleService;
    protected MessageNameResolver $messageNameResolver;
    protected MessageSerializer $serializer;
    protected OutboxRepository $outboxRepo;
    protected EventListenerProvider $eventProvider;
    protected EventBus $eventBus;
    protected MessageOutboxObjectWrapperFactory $outboxWrapper;

    protected function setUp(): void
    {
        parent::setUp();

        $this->messageNameResolver = new MessageNameResolver();
        $this->container = new InMemoryContainer();
        $this->mapper = new SimpleMapper();
        $this->assembler = new MessageAssemblerImpl($this->mapper);
        $this->moduleList = new ModuleListImpl();

        // messages
        $this->commandProvider = $this->createCommandProvider();
        $this->queryProvider = $this->createQueryProvider();
        $this->commandBus = $this->createCommandBus($this->commandProvider);
        $this->queryBus = $this->createQueryBus($this->queryProvider);

        $this->eventProvider = $this->createEventProvider();
        $this->serializer = new JMSMessageSerializer(
            $this->commandProvider,
            $this->queryProvider,
            $this->eventProvider,
            \JMS\Serializer\SerializerBuilder::create()->build()
        );
        $this->outboxRepo = new InMemoryOutboxRepository($this->serializer);
        $this->outboxWrapper = new MessageOutboxObjectWrapperFactory(
            $this->commandProvider,
            $this->queryProvider,
            $this->eventProvider
        );

        $this->eventBus = $this->createEventBus();

        // module service
        $this->moduleService = $this->createModuleService();
    }

    public function checkObjectPropertyValues(
        object $object,
        array $values
    ): void {
        $tester = new ExtractObjectPropertyTestUtil($object);
        $foundProps = $tester->getProperties();
        foreach ($values as $name => $value) {
            self::assertTrue(
                isset($foundProps[$name]),
                sprintf(
                    "expectected property %s:%s in %s",
                    $object::class,
                    $name,
                    implode(',', array_keys($foundProps)),
                )
            );

            self::assertEquals($foundProps[$name], $value);
        }
    }

    protected function createCommandProvider(): CommandListenerProvider
    {
        return new CmdLocator($this->container);
    }

    protected function createQueryProvider(): QueryListenerProvider
    {
        return new QueryLocator($this->container);
    }

    protected function createEventProvider(): EventListenerProvider
    {
        return new EventLocator($this->container);
    }

    protected function createQueryBus(
        QueryListenerProvider $provider
    ): QueryBus {
        return MessageBusFactory::createQueryBus($provider);
    }

    protected function createCommandBus(
        CommandListenerProvider $provider
    ): CommandBus {
        return MessageBusFactory::createCommandBus($provider);
    }

    protected function createEventBus(): EventBus
    {
        return MessageBusFactory::createEventBus($this->eventProvider);
    }

    private function createModuleService(): ModuleService
    {
        return new ModuleServiceImpl(
            $this->moduleList,
            $this->commandProvider,
            $this->queryProvider,
            $this->eventProvider
        );
    }

}