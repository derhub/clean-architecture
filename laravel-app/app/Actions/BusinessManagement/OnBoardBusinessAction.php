<?php

namespace App\Actions\BusinessManagement;

use App\Actions\ActionCapabilities;
use App\Actions\ApiResponse;
use Derhub\Shared\Message\Command\CommandBus;
use Derhub\Shared\Message\Command\CommandResponse;
use Derhub\Shared\Utils\Str;
use Derhub\Shared\Utils\Uuid;
use Illuminate\Http\JsonResponse;

class OnBoardBusinessAction
{
    use ActionCapabilities;

    public function __construct(private CommandBus $cmdBus)
    {
    }

    public function __invoke(): JsonResponse
    {
        $request = $this->getRequest();

        $name = $request->get('name');
        $slug = Str::slug($name);
        $result = $this->handle(
            name: $name,
            boardingStatus: $this->getOnBoardBy(),
            slug: $slug,
            ownerId: $this->getOwnerId(),
            country: $this->getCountry()
        );

        return ApiResponse::create(
            [
                'aggregate_id' => $result->aggregateRootId(),
            ]
        )->toJsonResponse()
            ;
    }

    public function handle(
        string $name,
        string $boardingStatus,
        string $slug,
        string $ownerId,
        string $country,
    ): CommandResponse {
        return $this->cmdBus->dispatch(
            new \Derhub\BusinessManagement\Business\Services\Onboard\OnBoardBusiness(
                name: $name,
                ownerId: $ownerId,
                slug: $slug,
                country: $country,
                onboardStatus: $boardingStatus
            )
        );
    }

    public function getOwnerId(): string
    {
        return Uuid::generate()->toString();
    }

    public function getOnBoardBy(): string
    {
        return 'onboard-owner';
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
        ];
    }

}
