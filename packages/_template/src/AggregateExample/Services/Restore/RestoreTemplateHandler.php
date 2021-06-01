<?php

namespace Derhub\Template\AggregateExample\Services\Restore;

use Derhub\Template\AggregateExample\Model\TemplateRepository;
use Derhub\Template\AggregateExample\Model\Values\TemplateId;
use Derhub\Template\AggregateExample\Services\CommandResponse;

final class RestoreTemplateHandler
{
    public function __construct(
        private TemplateRepository $repo
    ) {
    }

    /**
     * @throws \Derhub\Template\AggregateExample\Model\Exception\ChangesNotAllowed
     */
    public function __invoke(RestoreTemplate $msg): CommandResponse
    {
        $id = TemplateId::fromString($msg->aggregateRootId());

        /** @var \Derhub\Template\AggregateExample\Model\Template $model */
        $model = $this->repo->get($id);

        $model->restore();

        $this->repo->save($model);

        return new CommandResponse($id->toString());
    }
}
