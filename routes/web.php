<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaticViewController;
use App\Http\Controllers\CompaniesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

require __DIR__ . '/auth.php';

Route::get('/', [StaticViewController::class, 'homepage'])->name('homepage');

Route::group([
    'as' => 'dashboard.',
    'middleware' => ['auth'],
], function () {
    Route::get('/dashboard', function () {
        return Inertia\Inertia::render('Dashboard/Index');
    })->name('index');

    
    //Companies
    Route::group([
        'prefix' => 'companies',
        'as' => 'companies.',
        'controller' => CompaniesController::class
    ], function () {
        Route::get('/', 'list')->name('list');
        Route::post('/create', 'store')->name('create.post');
    });
});

