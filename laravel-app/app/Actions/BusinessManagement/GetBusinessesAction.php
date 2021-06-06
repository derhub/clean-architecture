<?php

namespace App\Actions\BusinessManagement;

use App\Actions\ActionCapabilities;
use App\Actions\ApiResponseFactory;
use Derhub\Shared\Message\Query\QueryResponse;
use Illuminate\Http\JsonResponse;

class GetBusinessesAction
{
    use ActionCapabilities;

    public function __invoke(): JsonResponse
    {
        $request = $this->getRequest();
        $enabled = (int)$request->get('enabled', -1);
        if ($enabled > -1) {
            $enabled = $enabled === 1;
        } else {
            $enabled = null;
        }

        $response = $this->handle(
            page: $request->get('page', 0),
            perPage: $request->get('per_page', 10),
            aggregateIds: $request->get('ids'),
            slugs: $request->get('slugs'),
            enabled: $enabled,
        );

        return ApiResponseFactory::create($response)->toJsonResponse();
    }

    public function handle(
        int $page,
        int $perPage,
        ?array $aggregateIds = null,
        ?array $slugs = null,
        null | bool | int $enabled = null,
        null | string | int | array $onBoardType = null,
    ): QueryResponse {
        return $this->getQueryBus()->dispatch(
            new \Derhub\BusinessManagement\Business\Services\GetBusinesses\GetBusinesses(
                $page,
                $perPage,
                $aggregateIds,
                $slugs,
                $enabled,
                $onBoardType,
            ),
        );
    }
}
