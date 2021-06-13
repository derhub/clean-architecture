<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Actions Routes
|--------------------------------------------------------------------------
|
| Here is where all the generated routes will be registered
|
*/

\App\BuildingBlocks\Actions\AutoRegisterActionRoutes::routes();

Route::get('/api', \App\Http\Controllers\ApiDocsController::class)->name('api.docs-api');
Route::get('/api/docs', [\App\Http\Controllers\ApiDocsController::class, 'swaggerUI'])->name('api.docs-ui');
