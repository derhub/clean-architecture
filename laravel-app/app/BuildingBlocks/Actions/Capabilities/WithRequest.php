<?php

namespace App\BuildingBlocks\Actions\Capabilities;

use Illuminate\Http\Request;
use Psr\Http\Message\ServerRequestInterface;

trait WithRequest
{
    protected ?ServerRequestInterface $request = null;

    public function setRequest(ServerRequestInterface $request): void
    {
        $this->request = $request;
    }

    public function getRequest(): ServerRequestInterface
    {
        return $this->request ?? \app()->get(ServerRequestInterface::class);
    }

    public function getRequestBody(): array
    {
        return $this->getRequest()->getParsedBody();
    }

    public function getRequestQueries(): array
    {
        return $this->getRequest()->getQueryParams();
    }
}
