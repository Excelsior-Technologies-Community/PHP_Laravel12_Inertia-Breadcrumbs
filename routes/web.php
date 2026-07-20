<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\SearchController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

Route::get('/users', [UserController::class, 'index'])
    ->name('users.index');

Route::get('/users/{id}', [UserController::class, 'show'])
    ->name('users.show');

Route::put('/users/{id}', [UserController::class, 'update'])
    ->name('users.update');

Route::get('/files', [FileController::class, 'index'])
    ->name('files.index');

Route::post('/files', [FileController::class, 'store'])
    ->name('files.store');

Route::delete('/files/{file}', [FileController::class, 'destroy'])
    ->name('files.destroy');

Route::get('/search', [SearchController::class, 'index'])
    ->name('search');