<?php


use App\Http\Controllers\EnvVariableController;
use Illuminate\Support\Facades\Route;

Route::prefix('configuracao/automata')->middleware('auth')->group(function () {
    Route::get('/', [EnvVariableController::class, 'index'])->name('configuration.index');
    Route::get('/{env_variable}/editar', [EnvVariableController::class, 'edit'])->name('configuration.edit');
    Route::put('/{env_variable}', [EnvVariableController::class, 'update'])->name('configuration.update');
    Route::get('/criar', [EnvVariableController::class, 'create'])->name('configuration.create');
    Route::post('/', [EnvVariableController::class, 'store'])->name('configuration.store');
    Route::delete('/{id}', [EnvVariableController::class, 'delete'])->name('configuration.delete');
});
