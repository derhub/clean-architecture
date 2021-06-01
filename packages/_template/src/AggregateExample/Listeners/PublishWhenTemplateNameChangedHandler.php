<?php

namespace Derhub\Template\AggregateExample\Listeners;

use Derhub\Template\AggregateExample\Infrastructure\Database\TemplatePersistenceRepository;
use Derhub\Template\AggregateExample\Model\Event\TemplateNameChanged;
use Derhub\Template\AggregateExample\Model\Values\TemplateId;

class PublishWhenTemplateNameChangedHandler
{
    public function __construct(
        private TemplatePersistenceRepository $repo
    ) {
    }

    /**
     * @throws \Derhub\Template\AggregateExample\Model\Exception\ChangesNotAllowed
     */
    public function __invoke(TemplateNameChanged $msg): void
    {
        $id = TemplateId::fromString($msg->aggregateRootId());

        $model = $this->repo->get($id);
        $model->publish();

        $this->repo->save($model);
    }
}