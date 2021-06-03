<?php

namespace App\Actions;

use Illuminate\Http\Request;

use function request;

trait ActionCapabilities
{
    protected function getCountry(): string
    {
        return config('general.country');
    }

    protected function getRequest(): Request
    {
        return request();
    }
}