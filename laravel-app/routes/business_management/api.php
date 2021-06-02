<?php


Route::get(
    '/api/business',
    function () {
        $request = \Request::instance();
        $bus =
            app()->make(\Derhub\Shared\Message\Query\QueryBus::class);

        $businessIds = $request->get('id', []);
        if (! is_array($businessIds)) {
            $businessIds = [$businessIds];
        }

        $source = $bus->dispatch(
            new \Derhub\BusinessManagement\Business\Services\GetBusinesses\GetBusinesses(
                page: (int)$request->get('page', 0),
                perPage: (int)$request->get('per_page', 100),
                aggregateIds: $businessIds
            ),
        );

        $results = [];
        foreach ($source->results() as $result) {
            $results[] = $result->toArray();
        }

        $data = [
            'meta' => [
                'cache_at' => Carbon\Carbon::now()->toDateTimeString(),
            ],
            'errors' => $source->errors(),
            'data' => $results,
        ];
        return new \Symfony\Component\HttpFoundation\JsonResponse($data);
    }
);

Route::get(
    '/api/business/{id}',
    function ($id) {
        $bus =
            app()->make(\Derhub\Shared\Message\Query\QueryBus::class);

        $source = $bus->dispatch(
            new \Derhub\BusinessManagement\Business\Services\GetByAggregateId\GetByAggregateId(
                $id
            ),
        );

        $data = [
            'meta' => [
                'cache_at' => Carbon\Carbon::now()->toDateTimeString(),
            ],
            'data' => $source->firstResult()->toArray(),
        ];


        return new \Symfony\Component\HttpFoundation\JsonResponse($data);
    }
);
