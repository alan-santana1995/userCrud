<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/doc', fn () => view('documentation'));

Route::resource('users', UserController::class)->only(['index', 'show', 'store', 'update']);
