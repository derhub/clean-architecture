<?php




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
