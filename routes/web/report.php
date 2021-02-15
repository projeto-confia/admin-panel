<?php

use App\Http\Controllers\Report\NewsController;
use Illuminate\Support\Facades\Route;

Route::get('/report/news', [NewsController::class, 'index']);