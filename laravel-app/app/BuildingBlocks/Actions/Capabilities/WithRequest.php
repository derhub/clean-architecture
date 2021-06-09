<?php

namespace App\BuildingBlocks\Actions\Capabilities;

use Illuminate\Http\Request;

trait WithRequest
{
    public function getRequest(): Request
    {
        return request();
    }

    public function input(string $key, mixed $default = null): mixed
    {
        return $this->getRequest()->get($key, $default);
    }

    public function inputHas(string $key): bool
    {
        return $this->getRequest()->has($key);
    }
}
