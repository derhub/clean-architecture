<?php

namespace Derhub\Template\AggregateExample\Services\ChangeName;

use Derhub\Template\AggregateExample\Model\Specification\UniqueNameSpec;
use Derhub\Template\AggregateExample\Model\TemplateRepository;
use Derhub\Template\AggregateExample\Model\Values\Name;
use Derhub\Template\AggregateExample\Model\Values\TemplateId;
use Derhub\Template\AggregateExample\Services\CommandResponse;
use MongoDB\Driver\Command;

class ChangeTemplateNameHandler
{
    public function __construct(
        private TemplateRepository $repo,
        private UniqueNameSpec $uniqueNameSpec
    ) {
    }

    /**
     * @throws \Derhub\Template\AggregateExample\Model\Exception\InvalidName
     * @throws \Derhub\Template\AggregateExample\Model\Exception\ChangesNotAllowed
     * @throws \Assert\AssertionFailedException
     */
    public function __invoke(ChangeTemplateName $msg): CommandResponse
    {
        $id = TemplateId::fromString($msg->aggregateRootId());
        $name = Name::fromString($msg->name());

        /** @var \Derhub\Template\AggregateExample\Model\Template $model */
        $model = $this->repo->get($id);

        $model->changeName($this->uniqueNameSpec, $name);

        $this->repo->save($model);

        return new CommandResponse($id->toString());
    }
}