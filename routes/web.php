<?php

use App\Http\Controllers\PerformancesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\StaticViewController;
use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\StatsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\IssuesController;
use App\Http\Controllers\UsersController;

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
Route::get('/documentation', [StaticViewController::class, 'doc'])->name('doc');
Route::get('/locale/{locale}', [StaticViewController::class, 'setLocale'])->name('locale.set');


Route::group([
    'as' => 'dashboard.',
    'middleware' => ['auth'],
], function () {
    Route::get('/dashboard', [StatsController::class, 'index'])->name('index');
    Route::get('/dashboard/cache/clear', [StatsController::class, 'clearCache'])->name('cache.clear');

    //Users
    Route::group([
        'prefix' => 'users',
        'as' => 'users.',
        'controller' => UsersController::class
    ], function () {
        Route::get('/search', 'search')->name('search');
    });

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
        Route::delete('/{company}/reject/{userId}', 'reject')->name('reject.delete');
        Route::patch('/{company}/accept/{userId}', 'accept')->name('accept.patch');
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
        Route::post('/{issue}/comment', 'addComment')->name('addComment.post');
        Route::post('/{issue}/assign', 'assignUser')->name('assignUser.post');
        Route::post('/{issue}/unassign', 'unassignUser')->name('unassignUser.post');
    });

    //Comments
    Route::group([
        'prefix' => 'comments',
        'as' => 'comments.',
        'controller' => CommentsController::class
    ], function () {
        Route::patch('/{comment}', 'editComment')->name('editComment.patch');
    });

    //Performances
    Route::group([
        'prefix' => 'performances',
        'as' => 'performances.',
        'controller' => PerformancesController::class
    ], function () {
        Route::get('/', 'list')->name('list');
        Route::get('/{performance}/show', 'details')->name('details');
        Route::post('/{performanceGroup}/comment', 'addComment')->name('addComment.post');
        Route::post('/{performanceGroup}/assign', 'assignUser')->name('assignUser.post');
        Route::post('/{performanceGroup}/unassign', 'unassignUser')->name('unassignUser.post');
    });
});

