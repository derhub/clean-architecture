<?php

namespace App\Actions;

use Derhub\Shared\Message\Command\CommandBus;
use Derhub\Shared\Message\Query\QueryBus;
use Illuminate\Http\Request;

use function request;

trait ActionCapabilities
{
    protected function getCommandBus(): CommandBus
    {
        return app()->get(CommandBus::class);
    }
    protected function getCountry(): string
    {
        return config('general.country');
    }

    protected function getQueryBus(): QueryBus
    {
        return app()->get(QueryBus::class);
    }

    protected function getRequest(): Request
    {
        return request();
    }

    protected function input(string $key, mixed $default = null): mixed
    {
        return $this->getRequest()->get($key, $default);
    }

    protected function inputAll(): array
    {
        return $this->getRequest()->all();
    }

    protected function inputHas(string $key): bool
    {
        return $this->getRequest()->has($key);
    }
}
