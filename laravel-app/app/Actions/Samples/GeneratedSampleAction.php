<?php

namespace App\Actions\Samples;

use App\BuildingBlocks\Actions\DispatcherResponse;

abstract class GeneratedSampleAction
{
    public static function fields(array $payload): array
    {
        return [
            'page' => [
                'required' => true,
                'default' => 0,
                'rules' => ['numeric'],
            ],
            'perPage' => [
                'required' => true,
                'default' => 100,
                'rules' => ['numeric'],
            ],
        ];
    }
    public static function withMessageClass(): string
    {
        return \Derhub\BusinessManagement\Business\Services\GetBusinesses\GetBusinesses::class;
    }

    abstract public function dispatch(): DispatcherResponse;
    public function __invoke(...$args): mixed
    {
        return $this->dispatch()->toJsonResponse();
    }
}
