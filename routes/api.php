<?php

use App\Domain\User\Controllers\UserController;
use App\Domain\User\Controllers\UserReportController;
use Illuminate\Support\Facades\Route;

Route::get('/doc', fn () => view('documentation'));

Route::resource('users', UserController::class)->only(['index', 'show', 'store', 'update', 'destroy']);
Route::get('users/report/{extension}', [UserReportController::class, 'export']);
