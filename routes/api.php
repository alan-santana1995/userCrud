<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/doc', fn () => view('documentation'));

Route::resource('/user', UserController::class)->except(['destroy', 'create', 'update']);
