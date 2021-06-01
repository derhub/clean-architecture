<?php

namespace Derhub\Template\AggregateExample\Services\Publish;

use Derhub\Template\AggregateExample\Model\TemplateRepository;
use Derhub\Template\AggregateExample\Model\Values\TemplateId;
use Derhub\Template\AggregateExample\Services\CommandResponse;

class PublishTemplateHandler
{
    public function __construct(
        private TemplateRepository $repo,
    ) {
    }

    public function __invoke(PublishTemplate $msg): CommandResponse
    {
        $id = TemplateId::fromString($msg->aggregateRootId());

        $model = $this->repo->get($id);

        $model->publish();

        $this->repo->save($model);

        return new CommandResponse($id->toString());
    }
}