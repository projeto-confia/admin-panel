<?php

use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::resource('/usuarios', UserController::class)
    ->parameters([
        'usuarios' => 'user'
    ])
    ->middleware('auth');

Route::put('/usuarios/{user}/bloquear', [UserController::class, 'block'])
    ->middleware('auth')
    ->name('usuarios.block');

Route::put('/usuarios/{user}/desbloquear', [UserController::class, 'unblock'])
    ->middleware('auth')
    ->name('usuarios.unblock');
