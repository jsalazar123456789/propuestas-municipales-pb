<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropuestaController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('propuestas.index');
    }
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return redirect()->route('propuestas.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::resource('propuestas', PropuestaController::class);
    Route::post('propuestas/{propuesta}/aprobar', [PropuestaController::class, 'aprobar'])->name('propuestas.aprobar');
    Route::post('propuestas/{propuesta}/rechazar', [PropuestaController::class, 'rechazar'])->name('propuestas.rechazar');
    Route::post('categorias', [CategoriaController::class, 'store'])->name('categorias.store');
    Route::get('reportes', [App\Http\Controllers\ReporteController::class, 'index'])->name('reportes.index');
    Route::resource('users', UserController::class);
});

require __DIR__.'/auth.php';
