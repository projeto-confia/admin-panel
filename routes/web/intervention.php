<?php

use App\Http\Controllers\InterventionReportController;
use Illuminate\Support\Facades\Route;


Route::resource('intervencoes', InterventionReportController::class)
    ->middleware('auth')
    ->only('index')
    ->parameters([
        'intervencao' => 'intervention'
    ]);
