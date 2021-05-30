<?php

namespace Derhub\Template\Services\Publish;

use Derhub\Shared\Exceptions\LayeredException;
use Derhub\Template\Model\TemplateRepository;
use Derhub\Template\Model\Values\TemplateId;
use Derhub\Template\Services\CommonCommandResponse;

class PublishTemplateHandler
{
    public function __construct(
        private TemplateRepository $repo,
    ) {
    }

    public function __invoke(PublishTemplate $msg): CommonCommandResponse
    {
        $response = new CommonCommandResponse($msg->aggregateRootId());
        try {
            $id = TemplateId::fromString($msg->aggregateRootId());

            $model = $this->repo->get($id);

            $model->publish();

            $this->repo->save($model);
        } catch (LayeredException $e) {
            $response->addErrorFromException($e);
        }

        return $response;
    }
}