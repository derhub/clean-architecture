<?php

namespace App\Actions;

use Derhub\Shared\Query\QueryItem;
use Illuminate\Http\JsonResponse;

use function is_array;
use function is_iterable;
use function json_encode;

class ApiResponse
{
    public const HTTP_SUCCESS = 200;

    private int $status;
    private array $errors;

    public static function create(
        iterable $data,
        int $status = self::HTTP_SUCCESS
    ): self {
        $self = new self($data);
        $self->setStatus($status);
        return $self;
    }

    public function __construct(private iterable $data)
    {
        $this->status = self::HTTP_SUCCESS;
        $this->errors = [];
        $this->data = [];
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

    public function setErrors(array $errors): self
    {
        $this->errors = $errors;
        return $this;
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function setData(array $data): self
    {
        $this->data = $data;
        return $this;
    }

    public function data(): array
    {
        if (is_array($this->data)) {
            return $this->data;
        }

        $results = [];
        foreach ($this->data as $data) {
            if ($data instanceof QueryItem) {
                $results[] = $data->toArray();
            }
        }
        return $results;
    }

    public function success(): bool
    {
        return empty($this->errors);
    }

    public function toArray(): array
    {
        return [
            'success' => $this->success(),
            'errors' => $this->errors(),
            'data' => $this->data(),
        ];
    }

    public function toJsonResponse(): JsonResponse
    {
        return JsonResponse::fromJsonString(
            json_encode($this->toArray()),
            $this->status
        );
    }
}