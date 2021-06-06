<?php

namespace App\Actions;

use Symfony\Component\HttpFoundation\JsonResponse;

interface ApiResponse
{
    public const HTTP_FAILED = 422;
    public const HTTP_SUCCESS = 200;

    public function data(): array;

    public function errors(): array;

    public function status(): int;

    public function success(): bool;

    public function toArray(): array;

    public function toJsonResponse(): JsonResponse;
}
