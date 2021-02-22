<?php

use App\Http\Controllers\Report\NewsController;
use App\Http\Controllers\Report\NewsChartController;
use Illuminate\Support\Facades\Route;

Route::prefix('report')->middleware('auth')->group(function () {
    Route::get('news', [NewsController::class, 'index'])->name('news.index');
    Route::get('news_chart', [NewsChartController::class, 'index'])->name('news_chart.index');
});
