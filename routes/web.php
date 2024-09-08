<?php

use App\Domain\User\Controllers\WebUserController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect(route('web.users.index')));

Route::get('users', [WebUserController::class, 'index'])->name('web.users.index');
Route::get('users/create', [WebUserController::class, 'create'])->name('web.users.create');
Route::get('users/{user}', [WebUserController::class, 'show'])->name('web.users.show');
Route::get('users/{user}/edit', [WebUserController::class, 'edit'])->name('web.users.edit');
