<?php

use App\Domain\User\Controllers\UserController;
use App\Domain\User\Controllers\UserReportController;
use Illuminate\Support\Facades\Route;

Route::resource('users', UserController::class)->only(['index', 'show', 'store', 'update', 'destroy']);
Route::get('users/report/csv', [UserReportController::class, 'csv'])->name('users.export.csv');
