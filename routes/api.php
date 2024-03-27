<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IssuesController;
use App\Http\Controllers\PerformancesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Project Keys routes
Route::group([
    'middleware' => ['project_key'],
], function () {
    Route::post('/issues/new', [IssuesController::class, 'create']);
    Route::post('/performances/new', [PerformancesController::class, 'create']);
});
