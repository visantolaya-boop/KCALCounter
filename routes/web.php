<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas para contador de calorías
    Route::get('/hoy', [App\Http\Controllers\CaloriasController::class, 'index'])->name('hoy');
    Route::get('/calorias', [App\Http\Controllers\CaloriasController::class, 'index'])->name('calorias.index'); // Para compatibilidad
    Route::post('/calorias', [App\Http\Controllers\CaloriasController::class, 'store'])->name('calorias.store');
    Route::delete('/calorias/{consumo}', [App\Http\Controllers\CaloriasController::class, 'destroy'])->name('calorias.destroy');
    Route::patch('/objetivo', [App\Http\Controllers\CaloriasController::class, 'updateObjetivo'])->name('objetivo.update');

    Route::get('/alimentos', [App\Http\Controllers\CaloriasController::class, 'alimentos'])->name('alimentos.index');
    Route::post('/alimentos', [App\Http\Controllers\CaloriasController::class, 'storeAlimento'])->name('alimentos.store');
    Route::patch('/alimentos/{alimento}', [App\Http\Controllers\CaloriasController::class, 'updateAlimento'])->name('alimentos.update');
    Route::delete('/alimentos/{alimento}', [App\Http\Controllers\CaloriasController::class, 'destroyAlimento'])->name('alimentos.destroy');

    Route::get('/historial', [App\Http\Controllers\CaloriasController::class, 'historial'])->name('historial');
});

require __DIR__.'/auth.php';
