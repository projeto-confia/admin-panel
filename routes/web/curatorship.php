<?php

use App\Http\Controllers\CuratorshipController;
use Illuminate\Support\Facades\Route;

Route::resource('curadoria', CuratorshipController::class)
    ->only('index', 'edit', 'update')
    ->parameters([
        'curadoria' => 'curatorship'
    ]);;
