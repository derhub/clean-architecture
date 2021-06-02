<?php

namespace Derhub\Integration\Laravel;

use Derhub\Integration\MessageOutbox\DoctrineOutboxMessageProcessor;
use Derhub\Shared\MessageOutbox\EventOutboxMessageFactory;
use Derhub\Shared\MessageOutbox\MessageOutboxWrapperFactory;
use Derhub\Shared\MessageOutbox\OutboxMessageConsumer;
use Derhub\Shared\MessageOutbox\OutboxMessageProcessor;
use Derhub\Shared\MessageOutbox\OutboxMessageRecorder;
use Derhub\Shared\MessageOutbox\OutboxMessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Derhub\Integration\LaravelEventBus\EventLaravelBus;
use Derhub\Integration\LaravelEventBus\EventHandlerProvider;
use Derhub\Integration\Mapper\SimpleMapper;
use Derhub\Integration\MessageBus\MessageAssembler;
use Derhub\Integration\MessageBus\MessageAssemblerImpl;
use Derhub\Integration\MessageOutbox\DoctrineOutboxRepository;
use Derhub\Integration\MessageOutbox\JMSMessageSerializer;
use Derhub\Integration\ModuleService\ModuleList;
use Derhub\Integration\ModuleService\ModuleListImpl;
use Derhub\Integration\ModuleService\ModuleService;
use Derhub\Integration\ModuleService\ModuleServiceImpl;
use Derhub\Integration\TacticianBus\Doctrine\PingConnectionMiddleware;
use Derhub\Integration\TacticianBus\Doctrine\TransactionMiddleware;
use Derhub\Integration\TacticianBus\Locator\CmdLocator;
use Derhub\Integration\TacticianBus\Locator\QueryLocator;
use Derhub\Integration\TacticianBus\MessageBusFactory;
use Derhub\Shared\Container\ContainerInterface;
use Derhub\Shared\Message\Command\CommandBus;
use Derhub\Shared\Message\Command\CommandListenerProvider;
use Derhub\Shared\Message\Event\EventBus;
use Derhub\Shared\Message\Event\EventListenerProvider;
use Derhub\Shared\Message\Query\QueryBus;
use Derhub\Shared\Message\Query\QueryListenerProvider;
use Derhub\Shared\MessageOutbox\MessageSerializer;
use Derhub\Shared\ObjectMapper\ObjectMapperInterface;
use Illuminate\Support\ServiceProvider;
use Illuminate\Container\Container;
use JMS\Serializer\SerializerInterface;

class LaravelServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(
            ContainerInterface::class,
            static fn ($app) => new LaravelContainer(
                static fn () => Container::getInstance()
            )
        );

        $this->app->bind(
            ObjectMapperInterface::class, SimpleMapper::class
        );

        $this->registerModuleRegistry();

        $this->registerOutboxMessage();
        $this->registerMessageBus();
        $this->registerCommand();
        $this->registerQuery();
        $this->registerEvent();
    }

    private function registerMessageBus(): void
    {
        $this->app->singleton(
            MessageAssembler::class,
            MessageAssemblerImpl::class
        );
    }

    private function registerModuleRegistry(): void
    {
        $this->app->singleton(
            ModuleList::class,
            ModuleListImpl::class,
        );

        $this->app->singleton(
            ModuleService::class,
            ModuleServiceImpl::class,
        );
    }

    private function registerCommand(): void
    {
        $this->app->singleton(
            CommandListenerProvider::class,
            CmdLocator::class
        );

        $this->app->singleton(
            CommandBus::class,
            function ($app) {
                $getConnection = static fn () => Container::getInstance()
                    ->get(EntityManagerInterface::class)
                    ->getConnection()
                ;
                return MessageBusFactory::createCommandBus(
                    $app->get(CommandListenerProvider::class),
                    [
                        new PingConnectionMiddleware($getConnection),
                        new TransactionMiddleware($getConnection),
                    ]
                );
            }
        );
    }

    public function registerQuery(): void
    {
        $this->app->singleton(
            QueryBus::class,
            function ($app) {
                $getConnection = static fn () => Container::getInstance()
                    ->get(EntityManagerInterface::class)
                    ->getConnection()
                ;
                return MessageBusFactory::createQueryBus(
                    $app->get(QueryListenerProvider::class),
                    [
                        new PingConnectionMiddleware($getConnection),
                    ]
                );
            }
        );

        $this->app->singleton(
            QueryListenerProvider::class,
            QueryLocator::class,
        );
    }

    private function registerEvent(): void
    {
        $this->app->singleton(
            EventBus::class,
            static function ($app) {
                return new EventLaravelBus(
                    $app->get(EventListenerProvider::class)
                );
//                return MessageBusFactory::createEventBus(
//                    $app->get(EventListenerProvider::class)
//                );
            }
        );

        $this->app->singleton(
            EventListenerProvider::class,
            EventHandlerProvider::class,
        );

//        $this->app->singleton(
//            EventListenerProvider::class,
//            EventLocator::class,
//        );
    }

    private function registerOutboxMessage(): void
    {
        $this->app->bind(
            SerializerInterface::class,
            static fn () => \JMS\Serializer\SerializerBuilder::create()->build()
        );

        $this->app->bind(MessageSerializer::class, JMSMessageSerializer::class);

        $this->app->bind(OutboxMessageConsumer::class, DoctrineOutboxRepository::class);
        $this->app->bind(OutboxMessageRecorder::class, DoctrineOutboxRepository::class);
        $this->app->bind(OutboxMessageProcessor::class, DoctrineOutboxMessageProcessor::class);

        $this->app->bind(
            MessageOutboxWrapperFactory::class, EventOutboxMessageFactory::class
        );
    }
}