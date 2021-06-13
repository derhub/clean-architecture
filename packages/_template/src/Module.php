<?php

namespace Derhub\Template;

use Derhub\Shared\Module\AbstractModule;
use Derhub\Template\AggregateExample\Infrastructure;
use Derhub\Template\AggregateExample\Services;

final class Module extends AbstractModule
{
    public const ID = 'id here';

    public function getId(): string
    {
        return self::ID;
    }

    public function start(): void
    {
        // You can also register dependencies here or in bootstrap.php file
        //$this->addDependency(
        //    Services\TemplateQueryItemMapper::class,
        //    Services\TemplateItemMapperImpl::class
        //);

        /**
         * Register Commands
         */
        //$this->addCommand(
        //    Services\Restore\RestoreTemplate::class,
        //    Services\Restore\RestoreTemplateHandler::class
        //);

        /**
         * Register Queries
         */
        $this->addQuery(
            Services\Query\GetById::class,
            Services\Query\GetByIdHandler::class
        );

        /**
         * Register events
         */
        //$this->addEvent(
        //    Model\Events\TemplateRestored::class,
        //    Model\Events\TemplateNameChanged::class,
        //    Model\Events\TemplateStatusChanged::class,
        //);

        // if the event is from this module you can register using class name
        //$this->addEventListener(
        //    Model\Events\TemplateNameChanged::class,
        //    [PublishWhenTemplateNameChangedHandler::class]
        //);

        // if the event is from outside you should register by name
        //$this->addEventListener(
        //    'business.events.BusinessNameChanged',
        //    [AlwaysPublishWhenTemplateNameChange::class]
        //);
    }
}
