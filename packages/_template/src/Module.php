<?php

namespace Derhub\Template;

use Derhub\Shared\Capabilities\ModuleCapabilities;
use Derhub\Shared\ModuleInterface;
use Derhub\Template\AggregateExample\Infrastructure;
use Derhub\Template\AggregateExample\Listeners\PublishWhenTemplateNameChangedHandler;
use Derhub\Template\AggregateExample\Model;
use Derhub\Template\AggregateExample\Services;

final class Module implements ModuleInterface
{
    use ModuleCapabilities;

    public const ID = 'template';

    public function getId(): string
    {
        return self::ID;
    }

    public function start(): void
    {
        $this->addDependency(
            Services\TemplateQueryItemMapper::class,
            Services\TemplateItemMapperImpl::class
        );
        $this->addDependency(
            Model\TemplateRepository::class,
            Infrastructure\Database\TemplatePersistenceRepository::class,
        );
        $this->addDependency(
            Infrastructure\Database\TemplateQueryRepository::class,
            Infrastructure\Database\Doctrine\DoctrineTemplateQueryRepository::class,
        );
        $this->addDependency(
            Model\Specification\UniqueNameSpec::class,
            Infrastructure\Specifications\QueryUniqueNameSpec::class,
        );

        /**
         * Commands
         */
        $this->addCommand(
            Services\Restore\RestoreTemplate::class,
            Services\Restore\RestoreTemplateHandler::class
        );
        $this->addCommand(
            Services\ChangeName\ChangeTemplateName::class,
            Services\ChangeName\ChangeTemplateNameHandler::class
        );
        $this->addCommand(
            Services\Publish\PublishTemplate::class,
            Services\Publish\PublishTemplateHandler::class
        );


        /**
         * Queries
         */
        $this->addQuery(
            Services\GetTemplates\GetTemplates::class,
            Services\GetTemplates\GetTemplatesHandler::class
        );
        $this->addQuery(
            Services\GetByAggregateId\GetByAggregateId::class,
            Services\GetByAggregateId\GetByAggregateIdHandler::class
        );

        /**
         * Events
         */
        $this->addEvent(
            Model\Event\TemplateRestored::class,
            Model\Event\TemplateNameChanged::class,
            Model\Event\TemplateStatusChanged::class,
        );

        // if the event is from this module you can register using class name
        $this->addEventListener(
            Model\Event\TemplateNameChanged::class,
            [PublishWhenTemplateNameChangedHandler::class]
        );

//        // if the event is from outside you should register by name
//        $this->addEventListener(
//            'business.events.BusinessNameChanged',
//            [AlwaysPublishWhenTemplateNameChange::class]
//        );
    }
}
