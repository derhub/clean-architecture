<?php

namespace Derhub\Template\Services\ChangeName;

use Derhub\Shared\Exceptions\LayeredException;
use Derhub\Template\Model\Specification\UniqueNameSpec;
use Derhub\Template\Model\TemplateRepository;
use Derhub\Template\Model\Values\Name;
use Derhub\Template\Model\Values\TemplateId;
use Derhub\Template\Services\CommonCommandResponse;

class ChangeTemplateNameHandler
{
    public function __construct(
        private TemplateRepository $repo,
        private UniqueNameSpec $uniqueNameSpec
    ) {
    }

    public function __invoke(ChangeTemplateName $msg): CommonCommandResponse
    {
        $response = new CommonCommandResponse($msg->aggregateRootId());
        try {
            $id = TemplateId::fromString($msg->aggregateRootId());
            $name = Name::fromString($msg->name());

            /** @var \Derhub\Template\Model\Template $model */
            $model = $this->repo->get($id);

            $model->changeName($this->uniqueNameSpec, $name);

            $this->repo->save($model);
        } catch (LayeredException $e) {
            $response->addErrorFromException($e);
        }

        return $response;
    }
}