<?php

namespace App\Actions;

use Illuminate\Http\JsonResponse;

class ApiValidateErrorResponse implements ApiResponse
{
    private array $errors = [];
    private int $status = self::HTTP_SUCCESS;

    public function data(): array
    {
        return [];
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function setErrors(array $errors): self
    {
        $this->errors = $errors;

        return $this;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function status(): int
    {
        return $this->status;
    }

    public function success(): bool
    {
        return false;
    }

    public function toArray(): array
    {
        return [
            'errors' => $this->errors(),
            'success' => $this->success(),
            'data' => [],
        ];
    }

    public function toJsonResponse(): JsonResponse
    {
        return JsonResponse::fromJsonString(
            json_encode($this->toArray()),
            $this->status()
        );
    }
}
