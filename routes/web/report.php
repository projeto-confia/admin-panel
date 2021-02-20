<?php

use App\Http\Controllers\Report\NewsController;
use Illuminate\Support\Facades\Route;

Route::prefix('report')->middleware('auth')->group(function () {
    Route::get('news', [NewsController::class, 'index'])->name('news.index');
});

