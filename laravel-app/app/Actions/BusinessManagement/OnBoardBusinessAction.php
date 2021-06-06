<?php

namespace App\Actions\BusinessManagement;

use App\Actions\ActionCapabilities;
use App\Actions\ApiResponseFactory;
use Derhub\Shared\Message\Command\CommandResponse;
use Derhub\Shared\Utils\Str;
use Derhub\Shared\Utils\Uuid;
use Illuminate\Http\JsonResponse;
use Validator;

class OnBoardBusinessAction
{
    use ActionCapabilities;

    public function __invoke(): JsonResponse
    {
        $validator = Validator::make($this->inputAll(), $this->rules());
        if ($validator->fails()) {
            return ApiResponseFactory::fromValidation($validator)
                ->toJsonResponse()
                ;
        }

        $name = $this->input('name');

        if (! $name && $this->inputHas('generate')) {
            $name = \Faker\Factory::create()->company;
        }

        $response = $this->handle(
            name: $name,
        );

        return ApiResponseFactory::create($response)->toJsonResponse();
    }

    public function getOnBoardBy(): string
    {
        return 'onboard-owner';
    }

    public function getOwnerId(): string
    {
        return Uuid::generate()->toString();
    }

    public function handle(
        string $name,
    ): CommandResponse {
        $slug = Str::slug($name);

        return $this->getCommandBus()
            ->dispatch(
                new \Derhub\BusinessManagement\Business\Services\Onboard\OnBoardBusiness(
                    name: $name,
                    ownerId: $this->getOwnerId(),
                    slug: $slug,
                    country: $this->getCountry(),
                    onboardStatus: $this->getOnBoardBy()
                )
            )
            ;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:100'],
        ];
    }
}
