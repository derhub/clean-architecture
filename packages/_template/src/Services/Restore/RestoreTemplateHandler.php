<?php

namespace Derhub\Template\Services\Restore;

use Derhub\Template\Model\TemplateRepository;
use Derhub\Template\Model\Values\TemplateId;
use Derhub\Template\Services\CommonCommandResponse;
use Derhub\Shared\Exceptions\ApplicationException;
use Derhub\Shared\Exceptions\DomainException;

final class RestoreTemplateHandler
{
    public function __construct(
        private TemplateRepository $repo
    ) {
    }

    public function __invoke(RestoreTemplate $msg): CommonCommandResponse
    {
        $response = new CommonCommandResponse($msg->aggregateRootId());
        try {
            $id = TemplateId::fromString($msg->aggregateRootId());

            /** @var \Derhub\Template\Model\Template $model */
            $model = $this->repo->get($id);

            $model->restore();

            $this->repo->save($model);
        } catch (DomainException | ApplicationException $e) {
            $response->addErrorFromException($e);
        }

        return $response;
    }
}
