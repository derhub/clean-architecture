<?php

namespace App\Actions\BusinessManagement;

use App\Actions\ActionCapabilities;
use App\Actions\ApiResponse;
use App\Actions\ServiceRequest;
use Derhub\BusinessManagement\Business\Services\Enable\EnableBusiness;
use Derhub\Shared\Message\Command\CommandResponse;
use Derhub\Shared\Message\Query\QueryResponse;
use Illuminate\Http\JsonResponse;


class EnableBusinessAction
{
    use ActionCapabilities;

    public function __construct(
        private \Derhub\Shared\Message\Command\CommandBus $bus,
        // private \Derhub\Shared\Message\Query\QueryBus $bus,
    )
    {
    }

    public function rules(): array
    {
        return [
            //TODO: add validation rules
        ];
    }

    public function handle(
        ServiceRequest $request,
        string $aggregateId
    ): JsonResponse {
        $response = $this->bus->dispatch(
            new EnableBusiness($aggregateId)
        );

        return ApiResponse::create(
         ['aggregate_id' => $response->aggregateRootId()] // for command
        // iterator_to_array($response->results()) // for query
        )->toJsonResponse()
            ;
    }
}
