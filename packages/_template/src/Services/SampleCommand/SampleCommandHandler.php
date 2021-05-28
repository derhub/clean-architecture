<?php

namespace EB\Template\Services\SampleCommand;

use EB\Shared\Exceptions\DomainException;
use EB\Shared\Exceptions\LayeredException;
use EB\Shared\Message\Command\CommandResponse;
use EB\Template\Model\TemplateRepository;
use EB\Template\Model\ValueObject\TemplateId;
use EB\Template\Services\CommonCommandResponse;
use EB\Template\Shared\Exception\AggregateNotFoundException;

class SampleCommandHandler
{
    public function __construct(
        private TemplateRepository $repo
    ) {
    }

    public function __invoke(SampleCommand $msg): CommandResponse
    {
        $response = new CommonCommandResponse();

        try {
            $id = TemplateId::fromString($msg->aggregateRootId());

            $model = $this->repo->get($id);

            if (! $model) {
                throw AggregateNotFoundException::fromId($id);
            }

            $this->repo->save($model);
        } catch (LayeredException $e) {
            $response->addErrorFromException($e);
        }
        return $response;
    }
}