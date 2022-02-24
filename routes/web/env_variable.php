<?php


use App\Http\Controllers\EnvVariableController;
use Illuminate\Support\Facades\Route;

Route::prefix('configuracao/automata')->middleware('auth')->group(function () {
    Route::get('/', [EnvVariableController::class, 'index'])->name('configuration.index');
    Route::put('/', [EnvVariableController::class, 'update'])->name('configuration.update');
});
