<?php

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

Route::get('/api', \App\Http\Controllers\ApiDocsController::class)->name('api.docs-api');
Route::get('/api/docs', [\App\Http\Controllers\ApiDocsController::class, 'swaggerUI'])->name('api.docs-ui');
Route::get('/api/validate', [\App\Http\Controllers\ApiDocsController::class, 'validateOpenApi'])->name('api.validateOpenApi');
