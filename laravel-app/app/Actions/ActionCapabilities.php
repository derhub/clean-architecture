<?php

namespace App\Actions;

use Illuminate\Http\Request;

trait ActionCapabilities
{
    public function getCountry(): string
    {
        return config('general.country');
    }

    public function getRequest(): Request
    {
        return request();
    }
}