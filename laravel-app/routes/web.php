<?php

include_once __DIR__.'/business_management/api.php';

use Derhub\Shared\Message\Command\CommandBus;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get(
    '/',
    function () {
        return view('welcome');
    }
);

Route::get(
    '/business-generate',
    function (CommandBus $bus) {
        $company = \Faker\Factory::create()->company;
        /** @var \Derhub\BusinessManagement\Business\Services\Onboard\OnBoardBusinessResponse $result */
        $result = $bus->dispatch(
            new \Derhub\BusinessManagement\Business\Services\Onboard\OnBoardBusiness(
                name: $company,
                ownerId: \Derhub\Shared\Utils\Uuid::generate()->toString(),
                slug: Str::slug($company),
                country: 'PH',
                onboardStatus: 'onboard-sales',
            ),
        );
        return [
            'aggregateId' => (string)$result->aggregateRootId(),
            'success' => $result->isSuccess(),
            'errors' => array_column($result->errors(), 'message'),
        ];
    }
);
