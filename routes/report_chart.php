<?php

// use App\Http\Controllers\Report\NewsController;
use Illuminate\Support\Facades\Route;

Route::get('/report/news_chart', function(){
    return view('pages.report.news_chart');
} );

// Route::get('/news_chart', [NewsChartController::class, 'index']);