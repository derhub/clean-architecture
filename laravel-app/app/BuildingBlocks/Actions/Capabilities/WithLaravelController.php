<?php

namespace App\BuildingBlocks\Actions\Capabilities;

use App\BuildingBlocks\Actions\DispatcherErrorResponse;
use App\BuildingBlocks\Actions\DispatcherResponse;
use Illuminate\Validation\ValidationException;

trait WithLaravelController
{
    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function __invoke(...$args): mixed
    {
        if (static::getRouteMethod() === 'post'
            && $this->getRequest()->getMethod() === 'GET') {
            return $this->onViewRequest();
        }

        if (static::getRouteMethod() === 'get') {
            return $this->returnViewOrCallback(
                fn () => $this->dispatch()->toJsonResponse()
            );
        }

        $response = $this->dispatch();

        if (! $this->isInertia()) {
            return $response->toJsonResponse();
        }

        if ($response instanceof DispatcherErrorResponse) {
            $error = $response->firstError();

            throw ValidationException::withMessages([$error['message']]);
        }

        return $this->onSuccessResponse($response);
    }

    public function onSuccessResponse(DispatcherResponse $response): mixed
    {
        return \redirect()->back();
    }

    public function returnViewOrCallback(callable $callback): mixed
    {
        try {
            return $this->onViewRequest();
        } catch (\Symfony\Component\HttpKernel\Exception\HttpException $e) {
            return $callback();
        }
    }

    public function onViewRequest(): mixed
    {
        $message = \sprintf(
            'The %s method is not supported for this action.',
            $this->getRequest()->getMethod()
        );

        if (\app()->environment() === 'local') {
            $message .= ' To support this method you can also override __invoke or implemented onViewRequest() '.static::class;
        }

        \app()->abort(
            405,
            $message,
        );
    }

    public function isInertia(): bool
    {
        return $this->getRequest()->hasHeader('x-inertia');
    }


    protected function getSegments(): array
    {
        return request()?->route()?->parameters() ?? [];
    }
}
