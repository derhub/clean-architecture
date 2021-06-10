<?php

namespace App\BuildingBlocks\Actions;

use Derhub\Shared\Message\Command\CommandResponse;
use Derhub\Shared\Message\Query\QueryResponse;
use Derhub\Shared\Query\QueryItem;
use Generator;
use Illuminate\Http\JsonResponse;

use function is_array;
use function json_encode;

class DispatcherSuccessResponse implements DispatcherResponse
{
    private Generator | array $data;
    private array $errors;
    private int $status;

    public function __construct(
        private null | CommandResponse | QueryResponse $response
    ) {
        $this->status = $this->response === null || $this->response->isSuccess()
            ? self::HTTP_SUCCESS
            : self::HTTP_FAILED;

        $this->errors = $this->response?->errors() ?? [];

        $this->data = [];
        if ($this->response instanceof CommandResponse) {
            $this->data =
                ['aggregate_id' => $this->response->aggregateRootId()];
        }

        if ($this->response instanceof QueryResponse) {
            $this->data = $this->response->results();
        }
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

    public function errors(): array
    {
        return $this->errors;
    }

    public function setData(array $data): self
    {
        $this->data = $data;

        return $this;
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
