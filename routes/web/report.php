<?php

// use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

// Route::get('/login', [AuthenticatedSessionController::class, 'create'])
//     ->middleware('guest')
//     ->name('login');

Route::get('/news', function(){
    return view('pages.report.news');
} );