<?php

use App\Http\Controllers\Report\NewsChartController;
use Illuminate\Support\Facades\Route;

Route::get('/report/news_chart', [NewsChartController::class, 'index']);