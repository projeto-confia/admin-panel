<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', WelcomeController::class)->name('welcome.show')->middleware('auth');

require __DIR__ . '/auth.php';
require __DIR__.'/web/report.php';
require __DIR__.'/web/users.php';
require __DIR__.'/web/curatorship.php';
require __DIR__.'/web/env_variable.php';
require __DIR__.'/web/intervention.php';

