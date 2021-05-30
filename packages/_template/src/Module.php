<?php

namespace Derhub\Template;

use Derhub\Template\Infrastructure;
use Derhub\Template\Model;
use Derhub\Template\Process\AlwaysPublishWhenTemplateNameChange;
use Derhub\Template\Services;
use Derhub\Shared\Capabilities\ModuleCapabilities;
use Derhub\Shared\ModuleInterface;

final class Module implements ModuleInterface
{
    use ModuleCapabilities;

    public const ID = 'business';

    public function getId(): string
    {
        return self::ID;
    }

    public function start(): void
    {
        $this->addDependency(
            Services\BusinessQueryItemMapper::class,
            Services\BusinessItemMapperDoctrine::class
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
            Model\Event\TemplatePublished::class,
        );

        // if the event is from this module you can register using class name
        $this->addEventListener(
            Model\Event\TemplateNameChanged::class,
            [AlwaysPublishWhenTemplateNameChange::class]
        );

//        // if the event is from outside you should register by name
//        $this->addEventListener(
//            'business.events.BusinessNameChanged',
//            [AlwaysPublishWhenTemplateNameChange::class]
//        );
    }
}
