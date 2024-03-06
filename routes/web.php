<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaticViewController;
use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\IssuesController;

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
        Route::get('/{company}/show', 'details')->name('details');
        Route::post('/create', 'store')->name('create.post');
        Route::get('/join/{company:key}', 'join')->name('join');
        Route::patch('/{company}/invitation', 'refresh_code')->name('refresh_code.patch');
    });

    //Profile
    Route::group([
        'prefix' => 'profile',
        'as' => 'profile.',
        'controller' => ProfileController::class
    ], function () {
        Route::get('/', 'show')->name('show');
        Route::post('/edit', 'editProfile')->name('edit.post');
        Route::post('/reset-password', 'resetPassword')->name('resetpassword.post');
    });

    //Projects
    Route::group([
        'prefix' => 'projects',
        'as' => 'projects.',
        'controller' => ProjectsController::class
    ], function () {
        Route::get('/', 'list')->name('list');
        Route::get('/{project}/show', 'details')->name('details');
        Route::post('/create', 'store')->name('create.post');
        Route::patch('/update', 'update')->name('update.patch');
        Route::patch('/{project}/invitation', 'refresh_code')->name('refresh_code.patch');
    });

    //Issues
    Route::group([
        'prefix' => 'issues',
        'as' => 'issues.',
        'controller' => IssuesController::class
    ], function () {
        Route::get('/', 'list')->name('list');
        Route::get('/{issue}/show', 'details')->name('details');
    });
});

