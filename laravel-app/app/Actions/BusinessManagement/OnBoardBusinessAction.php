<?php

namespace App\Actions\BusinessManagement;

use App\Actions\BaseAction;
use App\Actions\ApiResponseFactory;
use Derhub\Shared\Message\Command\CommandBus;
use Derhub\Shared\Message\Command\CommandResponse;
use Derhub\Shared\Utils\Str;
use Derhub\Shared\Utils\Uuid;
use Illuminate\Http\JsonResponse;

class OnBoardBusinessAction
{
    use BaseAction;

    public function __construct(private CommandBus $cmdBus)
    {
    }

    public function __invoke(): JsonResponse
    {
        $request = $this->getRequest();

        $name = $request->get('name');
        $response = $this->handle(
            name: $name,
        );

        return ApiResponseFactory::create($response)->toJsonResponse();
    }

    public function handle(
        string $name,
    ): CommandResponse {
        $slug = Str::slug($name);

        return $this->cmdBus->dispatch(
            new \Derhub\BusinessManagement\Business\Services\Onboard\OnBoardBusiness(
                name: $name,
                ownerId: $this->getOwnerId(),
                slug: $slug,
                country: $this->getCountry(),
                onboardStatus: $this->getOnBoardBy()
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
