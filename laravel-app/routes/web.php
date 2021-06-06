<?php

include_once __DIR__.'/business_management/api.php';

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
Route::get('/api/business', \App\Actions\BusinessManagement\GetBusinessesAction::class);
Route::get('/business-generate', \App\Actions\BusinessManagement\OnBoardBusinessAction::class);
