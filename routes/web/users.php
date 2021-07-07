<?php

use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::resource('/usuarios', UserController::class)
    ->parameters([
        'usuarios' => 'user'
    ])
    ->middleware('auth');

