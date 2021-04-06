<?php

use App\Http\Controllers\Report\NewsController;
use App\Http\Controllers\Report\NewsChartController;
use App\Http\Controllers\Report\NewsTagCloudController;
use App\Http\Controllers\Report\NewsActualDetectedController;
use Illuminate\Support\Facades\Route;

Route::prefix('report')->middleware('auth')->group(function () {
    Route::get('news', [NewsController::class, 'index'])->name('news.index');
    Route::get('news_chart', [NewsChartController::class, 'index'])->name('news_chart.index');
    Route::get('news_tagcloud', [NewsTagCloudController::class, 'index'])->name('news_tagcloud.index');
    Route::get('news_actual_detected', [NewsActualDetectedController::class, 'index'])->name('news_actual_detected.index');
});
